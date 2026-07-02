<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    protected function tearDown(): void
    {
        // Ensure maintenance mode is always disabled after each test
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
        }
        parent::tearDown();
    }

    // =================================================================
    // Notes on the test environment:
    //
    // The following features are not implemented in the current application,
    // so related tests are skipped:
    //   - Role-based access control (admin/general user)
    //   - Permission system (Policy / Gate)
    //
    // These would require additional application-level implementations.
    // =================================================================

    // =================================================================
    // Pending: Role & Permission tests (not applicable yet)
    // =================================================================

    public function test_role_based_access_control(): void
    {
        $this->markTestSkipped(
            'No role/permission system implemented in the current application. '
            . 'Skipped until role-based access control features are added.'
        );
    }

    public function test_insufficient_permissions_return_403(): void
    {
        $this->markTestSkipped(
            'No role/permission system implemented in the current application. '
            . 'Skipped until Policy/Gate features are added.'
        );
    }

    // =================================================================
    // 1. Sanctum API Token Authentication
    // =================================================================

    public function test_valid_sanctum_token_allows_access(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Token User',
            'email' => 'token-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(200);
        $response->assertJson(['id' => $userId, 'name' => 'Token User']);
    }

    public function test_invalid_sanctum_token_returns_401(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid-token-string',
            'Accept' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_malformed_token_returns_401(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer',
            'Accept' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(401);
    }

    public function test_empty_authorization_header_returns_401(): void
    {
        $response = $this->withHeaders([
            'Authorization' => '',
            'Accept' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(401);
    }

    public function test_no_auth_header_on_protected_route_returns_401(): void
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user');

        $response->assertStatus(401);
    }

    // =================================================================
    // 2. CSRF Protection (Web routes)
    // =================================================================

    public function test_csrf_middleware_blocks_request_without_token(): void
    {
        // VerifyCsrfToken bypasses CSRF in the 'testing' environment (runningUnitTests()).
        // Use a test subclass that overrides this check to test actual blocking behavior.
        $request = \Illuminate\Http\Request::create('/test', 'POST');
        $request->setLaravelSession(app('session')->driver());
        $next = fn($req) => response('ok');

        $middleware = new CsrfTestMiddleware();

        $this->expectException(\Illuminate\Session\TokenMismatchException::class);
        $middleware->handle($request, $next);
    }

    public function test_csrf_middleware_passes_with_valid_token(): void
    {
        // When a valid CSRF token is provided, the middleware should allow the request
        $request = \Illuminate\Http\Request::create('/test', 'POST', ['_token' => 'test-token']);
        $session = app('session')->driver();
        $session->put('_token', 'test-token');
        $request->setLaravelSession($session);
        $next = fn($req) => response('ok');

        $middleware = new CsrfTestMiddleware();

        $response = $middleware->handle($request, $next);
        $this->assertSame(200, $response->status());
    }

    public function test_csrf_middleware_is_configured_in_kernel(): void
    {
        $kernel = app()->make(\App\Http\Kernel::class);
        $reflection = new \ReflectionClass($kernel);
        $middlewareGroupsProperty = $reflection->getProperty('middlewareGroups');
        $middlewareGroupsProperty->setAccessible(true);
        $middlewareGroups = $middlewareGroupsProperty->getValue($kernel);

        $this->assertContains(
            \App\Http\Middleware\VerifyCsrfToken::class,
            $middlewareGroups['web']
        );
    }

    public function test_post_to_api_route_skips_csrf_verification(): void
    {
        // API routes are excluded from CSRF verification (see VerifyCsrfToken::$except)
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('/api/login', [
                'email' => 'nonexistent@example.com',
                'password' => 'password',
            ]);

        // Should NOT be 419 (CSRF token mismatch) - api/* and login are excluded
        $this->assertNotEquals(419, $response->status());
    }

    // =================================================================
    // 3. Rate Limiting (Throttle)
    // =================================================================

    public function test_throttle_blocks_requests_after_limit_exceeded(): void
    {
        // Register a route with a low throttle limit (2 requests per minute)
        Route::middleware('throttle:2,1')->get('/api/test-throttle', function () {
            return response()->json(['status' => 'ok']);
        });

        // First request should succeed
        $response1 = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/test-throttle');
        $this->assertEquals(200, $response1->status());

        // Second request should succeed
        $response2 = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/test-throttle');
        $this->assertEquals(200, $response2->status());

        // Third request should be rate-limited (429)
        $response3 = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/test-throttle');
        $response3->assertStatus(429);
    }

    public function test_throttle_headers_present_on_rate_limited_response(): void
    {
        Route::middleware('throttle:1,1')->get('/api/test-throttle-headers', function () {
            return response()->json(['status' => 'ok']);
        });

        // First request - consume the limit
        $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/test-throttle-headers')
            ->assertStatus(200);

        // Second request - should be rate limited with proper headers
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/test-throttle-headers');

        $response->assertStatus(429);
        $response->assertHeader('Retry-After');
    }

    // =================================================================
    // 4. Maintenance Mode
    // =================================================================

    public function test_maintenance_mode_returns_503(): void
    {
        Artisan::call('down');

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/get_studio_list');

        $response->assertStatus(503);
    }

    public function test_maintenance_mode_protected_route_returns_503(): void
    {
        Artisan::call('down');

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user');

        $response->assertStatus(503);
    }

    public function test_normal_operation_after_maintenance_mode_disabled(): void
    {
        Artisan::call('down');
        Artisan::call('up');

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/get_studio_list');

        $this->assertNotEquals(503, $response->status());
    }

    // =================================================================
    // 5. Custom Middleware: AddSecurityHeader
    // =================================================================

    public function test_security_headers_are_present_in_response(): void
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/get_studio_list');

        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_security_headers_have_expected_csp_value(): void
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/get_studio_list');

        $expectedCsp = "default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; frame-ancestors 'self'; form-action 'self';";
        $this->assertSame($expectedCsp, $response->headers->get('Content-Security-Policy'));
    }

    public function test_security_headers_are_present_on_all_routes(): void
    {
        // Test public route
        $responsePublic = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/get_time_options');
        $responsePublic->assertHeader('Content-Security-Policy');
        $responsePublic->assertHeader('X-Content-Type-Options', 'nosniff');

        // Test 404 route (middleware runs before route resolution for global middleware)
        $response404 = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/nonexistent-route');
        $response404->assertHeader('Content-Security-Policy');
        $response404->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    // =================================================================
    // 6. Auth: actingAs + Sanctum token consistency
    // =================================================================

    public function test_acting_as_and_sanctum_token_both_work(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Consistency User',
            'email' => 'consistency@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);

        // Test 1: actingAs (session-based)
        $responseSession = $this->actingAs($user)
            ->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user');

        $responseSession->assertStatus(200);

        // Test 2: Sanctum token (token-based)
        $token = $user->createToken('test-token-2')->plainTextToken;

        $responseToken = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/user');

        $responseToken->assertStatus(200);
    }
}

/**
 * Test subclass of VerifyCsrfToken that overrides runningUnitTests() to return false.
 * This allows testing CSRF blocking behavior in the testing environment,
 * where Laravel normally bypasses CSRF verification automatically.
 */
class CsrfTestMiddleware extends \App\Http\Middleware\VerifyCsrfToken
{
    public function __construct()
    {
        // Resolve constructor dependencies from the container
        parent::__construct(app(), app()->make(\Illuminate\Contracts\Encryption\Encrypter::class));
    }

    protected function runningUnitTests(): bool
    {
        return false;
    }
}

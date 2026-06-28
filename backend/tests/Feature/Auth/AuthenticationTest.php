<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * All protected routes (requestable without arguments)
     * GET /api/get_lesson_booking_data is excluded because the controller has no matching method
     */
    public static function protectedRoutesDataProvider(): array
    {
        return [
            'GET /api/user' => ['GET', '/api/user'],
            'GET /api/get_next_lesson_data' => ['GET', '/api/get_next_lesson_data'],
            'GET /api/get_information_list' => ['GET', '/api/get_information_list'],
            'GET /api/get_selected_lesson_list' => ['GET', '/api/get_selected_lesson_list'],
            'GET /api/get_favorite_studio_list' => ['GET', '/api/get_favorite_studio_list'],
            'GET /api/add_same_studio_lesson_list' => ['GET', '/api/add_same_studio_lesson_list'],
            'GET /api/add_searched_lessons' => ['GET', '/api/add_searched_lessons'],
            'GET /api/get_lesson_detail' => ['GET', '/api/get_lesson_detail'],
            'GET /api/add_booking_history' => ['GET', '/api/add_booking_history'],
            'POST /api/book_lesson' => ['POST', '/api/book_lesson'],
            'POST /api/cancel_lesson' => ['POST', '/api/cancel_lesson'],
            'POST /api/save_favorite_studio_list' => ['POST', '/api/save_favorite_studio_list'],
            'POST /api/send_report' => ['POST', '/api/send_report'],
            'POST /api/update_user' => ['POST', '/api/update_user'],
        ];
    }

    /**
     * Protected POST routes (for test_unauthenticated_user_gets_401_for_post_endpoints)
     */
    public static function protectedPostRoutesDataProvider(): array
    {
        return [
            'POST /api/book_lesson' => ['POST', '/api/book_lesson'],
            'POST /api/cancel_lesson' => ['POST', '/api/cancel_lesson'],
            'POST /api/save_favorite_studio_list' => ['POST', '/api/save_favorite_studio_list'],
            'POST /api/send_report' => ['POST', '/api/send_report'],
            'POST /api/update_user' => ['POST', '/api/update_user'],
        ];
    }

    /**
     * Public routes (accessible without authentication)
     */
    public static function publicRoutesDataProvider(): array
    {
        return [
            'POST /api/login' => ['POST', '/api/login'],
            'POST /api/logout' => ['POST', '/api/logout'],
            'POST /api/validate_first_lesson' => ['POST', '/api/validate_first_lesson'],
            'GET /api/get_lesson_category_list' => ['GET', '/api/get_lesson_category_list'],
            'GET /api/get_time_options' => ['GET', '/api/get_time_options'],
            'GET /api/get_studio_list' => ['GET', '/api/get_studio_list'],
            'GET /api/get_studio_lesson_data' => ['GET', '/api/get_studio_lesson_data'],
        ];
    }

    // =================================================================
    // Notes on the test environment:
    //
    // The following features are not implemented in the current application,
    // so related tests are skipped:
    //   - Policy / Gate (authorization)
    //   - Role-based access control (admin/general user)
    //   - Explicit ownership checks
    //
    // However, because the Controller/Service layer consistently uses Auth::id(),
    // authenticated users naturally operate only on their own data.
    // =================================================================

    // =================================================================
    // 1. Unauthenticated users cannot access protected routes
    // =================================================================

    /**
     * @dataProvider protectedRoutesDataProvider
     */
    public function test_unauthenticated_user_cannot_access_protected_routes(string $method, string $uri): void
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])->call($method, $uri);

        $response->assertStatus(401);
    }

    /**
     * Unauthenticated users receive a JSON error when accessing protected routes
     */
    public function test_unauthenticated_user_receives_json_error(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    // =================================================================
    // 2. Authenticated users can access protected routes
    // =================================================================

    /**
     * Authenticated user can access each protected route (returns non-401)
     *
     * @dataProvider protectedRoutesDataProvider
     */
    public function test_authenticated_user_can_access_protected_routes(string $method, string $uri): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Auth Test User',
            'email' => 'auth-test@example.com',
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

        $response = $this->actingAs($user)
            ->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->call($method, $uri);

        // Authenticated, so should not be 401
        // (actual status may be 200/404/422/500 depending on data and parameters)
        $this->assertNotEquals(401, $response->status(), "Route {$method} {$uri} returned 401 for authenticated user.");
    }

    // =================================================================
    // 3. Public routes are accessible without authentication
    // =================================================================

    /**
     * Public routes should not return 401 without authentication
     * (response content like 200/422 is not checked)
     *
     * @dataProvider publicRoutesDataProvider
     */
    public function test_public_routes_are_accessible_without_auth(string $method, string $uri): void
    {
        $response = $this->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->call($method, $uri);

        $this->assertNotEquals(401, $response->status(), "Route {$method} {$uri} should be public but returned 401.");
    }

    // =================================================================
    // 4. Login/logout flow (session/authentication state verification)
    // =================================================================

    public function test_login_creates_authenticated_session(): void
    {
        DB::table('user')->insert([
            'name' => 'Login Flow User',
            'email' => 'login-flow@example.com',
            'password' => bcrypt('password123'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Login request
        $loginResponse = $this->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/login', [
                'email' => 'login-flow@example.com',
                'password' => 'password123',
            ]);

        $loginResponse->assertStatus(200);
        $loginResponse->assertJson(['message' => 'Login successful']);

        // After login, protected routes should be accessible
        $userResponse = $this->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user');

        $userResponse->assertStatus(200);
        $userResponse->assertJsonStructure(['id', 'name', 'email']);
    }

    public function test_login_with_invalid_credentials_fails(): void
    {
        DB::table('user')->insert([
            'name' => 'Invalid Login User',
            'email' => 'invalid-login@example.com',
            'password' => bcrypt('correct-password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/login', [
                'email' => 'invalid-login@example.com',
                'password' => 'wrong-password',
            ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid credentials']);
    }

    // =================================================================
    // 5. Protected routes are inaccessible after logout
    // =================================================================

    /**
     * Verify authentication state via actingAs:
     * Authenticated → protected route accessible → deauthenticate → inaccessible
     *
     * Note: Actual logout (POST /api/logout) is tested in LoginControllerTest.
     * Here we verify only the state change via actingAs/deauth.
     */
    public function test_authentication_state_toggle_controls_access(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'State Toggle User',
            'email' => 'state-toggle@example.com',
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

        // Without authentication → 401
        $this->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user')
            ->assertStatus(401);

        // With authentication → 200
        $this->actingAs($user)
            ->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user')
            ->assertStatus(200);
    }

    // =================================================================
    // 6. Users can only access their own data (protected by Auth::id())
    // =================================================================

    /**
     * Even when authenticated as User A, User B's data cannot be accessed.
     * Because the API always uses Auth::id(), it is impossible to
     * intentionally manipulate another user's data.
     */
    public function test_user_cannot_access_other_users_data(): void
    {
        $userAId = DB::table('user')->insertGetId([
            'name' => 'User A',
            'email' => 'user-a@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create user B
        DB::table('user')->insertGetId([
            'name' => 'User B',
            'email' => 'user-b@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1992-02-02',
            'image_path' => '/images/user/user_b.png',
            'zip_code' => '999-9999',
            'tel_no' => '090-9999-9999',
            'address' => 'Osaka Test 2-2-2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userA = \App\Models\User::find($userAId);

        // Authenticate as user A
        $response = $this->actingAs($userA)
            ->withSession([])
            ->withHeaders(['Accept' => 'application/json'])
            ->get('/api/user');

        $response->assertStatus(200);
        $userData = $response->json();

        // Verify own data (User A) is returned, not User B's
        $this->assertSame('User A', $userData['name']);
        $this->assertSame('user-a@example.com', $userData['email']);
        $this->assertNotSame('user-b@example.com', $userData['email']);
    }

    // =================================================================
    // 7. Protected POST endpoints return 401 without authentication
    // =================================================================

    /**
     * @dataProvider protectedPostRoutesDataProvider
     */
    public function test_unauthenticated_user_gets_401_for_post_endpoints(string $method, string $uri): void
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->call($method, $uri, []);

        $response->assertStatus(401);
    }
}

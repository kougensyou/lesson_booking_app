<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutController extends Controller
{
    /**
     * @param AuthManager $auth
     */
    public function __construct(
        private readonly AuthManager $auth,
    ) {
    }

    public function logout(Request $request): object
    {
        if ($this->auth->guard()->guest()) {
            return new JsonResponse([
                'message' => 'Already Unauthenticated.',
            ]);
        }

        $this->auth->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
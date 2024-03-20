<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $email = $request->email;
        $user = User::where('users.email', $email)->first();

        if ($user) {
            $userStatus = $user->status;
            if ($userStatus != "active") {
                return response("Users is not active, please contact admin", Response::HTTP_UNAUTHORIZED);
            }
        }

        $request->authenticate();
        $request->session()->regenerate();
        return response(Auth::user());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $response = [
            "message" => "success",
            "status" => 200
        ];
        return response($response);
    }
}

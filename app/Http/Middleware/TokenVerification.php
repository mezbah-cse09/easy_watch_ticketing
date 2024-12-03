<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     $token = $request->cookie('token');
    //     if (!$token) {
    //         return redirect('/userLogin');
    //     }

    //     $result = JWTToken::VerifyToken($token);
    //     if ($result == 'unauthorized') {
    //         return redirect('/userLogin');
    //     }

    //     if (is_object($result)) {
    //         $request->headers->set('email', $result->userEmail);
    //         $request->headers->set('id', $result->userId);
    //         return $next($request);
    //     }

    //     return redirect('/userLogin');
    // }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        if (!$token) {
            return redirect('/userLogin')->with('error', 'You need to log in first.');
        }

        $result = JWTToken::VerifyToken($token);
        if ($result == 'unauthorized') {
            return redirect('/userLogin')->with('error', 'Your session has expired.');
        }

        if (is_object($result)) {
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userId);

            $role = $result->userRole;
            switch ($role) {
                case 'admin':
                    $request->headers->set('role', 'admin');
                    break;
                case 'customer':
                    $request->headers->set('role', 'customer');
                    break;
                case 'employee':
                    $request->headers->set('role', 'employee');
                    break;
                default:
                    return response()->json([
                        'message' => 'Invalid role.',
                        'status' => 'error',
                    ], 403);
            }
            return $next($request);
        }

        return redirect('/userLogin')->with('error', 'Unauthorized access.');
    }
}

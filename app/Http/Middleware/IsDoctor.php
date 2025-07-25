<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsDoctor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'doctor') {
                // Check if the doctor's account is approved
                if ($user->status == 'approved') {
                    return $next($request);
                }

                // If status is not approved
                auth()->logout();
                return redirect('/login')->withErrors([
                    'email' => 'Your doctor account is not approved yet.',
                ]);
            }
        }

        abort(403, 'Unauthorized');
    }
}

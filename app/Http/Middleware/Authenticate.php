<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Check if the user is authenticated
        if (Auth::check()) {
            $userType = Auth::user()->user_type;

            // Redirect based on user_type
            switch ($userType) {
                case 1: // Admin
                    return redirect()->route('admin_dashboard');
                case 2: // Agent
                    return redirect()->route('agent_dashboard');
                case 3: // Applicant
                    return redirect()->route('applicant_dashboard');
                case 4: // Lawyer
                    return redirect()->route('lawyer_dashboard');
                default:
                    return redirect()->route('sign_in')->with('error', 'User type not recognized');
            }
        }

        return $next($request);
    }
}

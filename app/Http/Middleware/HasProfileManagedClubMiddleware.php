<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasProfileManagedClubMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profile = Profile::select("managed_club")
            ->where('id', session()->get('profile_id'))
            ->first();

        if ($profile->managed_club == null) {
            return redirect('/profile-select-club');
        }

        return $next($request);
    }
}

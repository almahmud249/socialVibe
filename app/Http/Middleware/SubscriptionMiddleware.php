<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->client) {
            // Subscription restriction removed: allow client panel access without active plan.
            return $next($request);
        }
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionTier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $tier  The minimum required subscription tier (admin, paid_member, free_member)
     */
    public function handle(Request $request, Closure $next, string $tier = 'free_member'): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'error' => 'You must be logged in to access this resource.'
            ], 401);
        }

        $user = $request->user();

        // Define tier hierarchy (higher number = higher tier)
        $tierHierarchy = [
            'free_member' => 1,
            'paid_member' => 2,
            'admin' => 3,
        ];

        // Check if the user's role meets the required tier
        $userTierLevel = $tierHierarchy[$user->role] ?? 0;
        $requiredTierLevel = $tierHierarchy[$tier] ?? 0;

        if ($userTierLevel < $requiredTierLevel) {
            return response()->json([
                'message' => 'Access denied.',
                'error' => "This endpoint requires a {$tier} subscription or higher.",
                'your_role' => $user->role,
                'required_role' => $tier,
                'upgrade_info' => $tier === 'paid_member'
                    ? 'Upgrade to a paid membership to access this feature.'
                    : 'This feature is restricted to administrators.'
            ], 403);
        }

        return $next($request);
    }
}

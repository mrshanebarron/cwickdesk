<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpWhitelist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = app('currentTenant');

        if (!$tenant) {
            return $next($request); // No tenant, skip check
        }

        // Check if IP whitelisting is enabled for this tenant
        if (!$tenant->ip_whitelist_enabled) {
            return $next($request); // Whitelisting disabled
        }

        $clientIp = $request->ip();
        $whitelist = $tenant->ip_whitelist ?? [];

        // If whitelist is empty but enabled, block all
        if (empty($whitelist)) {
            abort(403, 'Access denied: IP not whitelisted');
        }

        // Check if client IP matches any whitelisted IP or CIDR range
        foreach ($whitelist as $allowedIp) {
            if ($this->ipMatches($clientIp, $allowedIp)) {
                return $next($request);
            }
        }

        // IP not in whitelist
        abort(403, 'Access denied: IP not whitelisted');
    }

    /**
     * Check if IP matches the allowed IP or CIDR range
     */
    protected function ipMatches(string $clientIp, string $allowedIp): bool
    {
        // Exact match
        if ($clientIp === $allowedIp) {
            return true;
        }

        // CIDR range check
        if (str_contains($allowedIp, '/')) {
            [$range, $netmask] = explode('/', $allowedIp, 2);
            $rangeDecimal = ip2long($range);
            $ipDecimal = ip2long($clientIp);
            $wildcardDecimal = pow(2, (32 - $netmask)) - 1;
            $netmaskDecimal = ~$wildcardDecimal;

            return ($ipDecimal & $netmaskDecimal) == ($rangeDecimal & $netmaskDecimal);
        }

        return false;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictByIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->ip());

        // $allowedIPs = ['192.168.139.103', '192.168.139.91']; // Ganti dengan IP sekolah

        // if (!in_array($request->ip(), $allowedIPs)) {
        //     abort(403, 'Akses hanya diperbolehkan melalui jaringan sekolah.');
        // }
        
        $userIP = $request->ip(); // Ganti dengan IP sekolah

        if (!$this->isIpInRange($userIP, '192.168.78.0', '192.168.78.255')) {
            abort(403, 'Akses hanya diperbolehkan dalam jaringan sekolah.');
        }
        return $next($request);
    }

    private function isIpInRange($ip, $start, $end)
    {
        return (ip2long($ip) >= ip2long($start) && ip2long($ip) <= ip2long($end));
    }
}

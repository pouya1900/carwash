<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StringToNumber
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        foreach ($request->input() as $key => $item) {
            $request[$key] = $this->turnToNumber($item);
        }
        return $next($request);
    }

    public function turnToNumber($item)
    {
        if (is_array($item)) {
            foreach ($item as $key => $item2) {
                $item[$key] = $this->turnToNumber($item2);
            }
            return $item;
        }
        $x = str_replace(",", "", $item);
        if (is_numeric($x)) {
            if (str_contains($x, ".")) {
                $item = floatval($x);
            } else {
                $item = intval($x);
            }
        }

        return $item;
    }
}

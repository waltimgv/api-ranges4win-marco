<?php

namespace App\Http\Middleware;

use App\CombinationLink;
use Closure;

class RedirectIfLinkIsPaid
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->link) === false && isset($request->link_id) === false) {
            return response()->json(['error' => 'Bad Request'], 400);
        }

        if (isset($request->link)) {
            return $this->handleLink($request, $next);
        }

        if (isset($request->link_id)) {
            return $this->handleLinkId($request, $next);
        }

        return $this->unauthorized();
    }

    private function handleLink($request, Closure $next)
    {
        return $this->check($request->link, $request, $next);
    }

    private function handleLinkId($request, Closure $next)
    {
        $link = CombinationLink::query()->find($request->link_id);
        return $this->check($link, $request, $next);
    }

    private function check(CombinationLink $link, $request, Closure $next)
    {
        if (($link->is_free === false) && (auth()->user()->is_plan_expired === true)) {
            return $this->unauthorized();
        }

        return $next($request);
    }

    private function unauthorized()
    {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

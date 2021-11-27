<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;

class SuggestAppeal
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('appeal', false)) {
            return $next($request);
        }

        $settings = app(Settings::class);

        if ($request->session()->missing('max_count')) {
            $request->session()->put('max_count', 0);
            $request->session()->put('cur_count', 0);
        }
        if ($request->session()->get('max_count') < $settings->maximum_count) {
            if ($request->session()->get('cur_count') < $settings->frequency) {
                $request->session()->increment('cur_count');
            } else {
                $request->session()->now('show_suggest', true);
                $request->session()->put('show_message', true);
                $request->session()->increment('max_count');
                $request->session()->put('cur_count', 0);
            }
        }

        return $next($request);
    }
}

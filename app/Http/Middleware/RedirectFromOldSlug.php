<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class RedirectFromOldSlug
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
        $redirect = Redirect::where('old_slug', parse_url($request->url(), PHP_URL_PATH))
            ->orderByDesc('created_at')
            ->first();

        $slug = null;
        while ($redirect !== null)
        {
            $slug = $redirect->new_slug;
            $redirect = Redirect::where('old_slug', $slug)
                ->where('created_at', '>', $redirect->created_at)
                ->orderByDesc('created_at')
                ->first();
        }
        if ($slug != null) {
            return redirect($slug);
        }
        return $next($request);
    }
}

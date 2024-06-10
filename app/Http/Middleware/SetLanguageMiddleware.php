<?php

namespace App\Http\Middleware;

use App\Models\Translate;
use Closure;
use Illuminate\Http\Request;

class SetLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $language = in_array($request->lang, Translate::LANGUAGES) ? $request->lang : Translate::DEFAULT_LANG;

        app()->setLocale($language);
        $request->merge(['language' => $language]);

        return $next($request);
    }
}

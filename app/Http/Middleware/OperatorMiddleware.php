<?php

namespace App\Http\Middleware;

use Closure;

class OperatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
\Artisan::call('view:clear');
        if(isset($_SERVER['HTTP_HOST'])) {
            if($_SERVER['HTTP_HOST']!='chat.neiros.ru') {
                if (auth()->user()->is_operator()) {
                    return redirect('https://chat.neiros.ru');
                }

                if(is_null(auth()->user()->is_operator())){
                    return abort(404);
                }
            }
        }
        return $next($request);
    }
}

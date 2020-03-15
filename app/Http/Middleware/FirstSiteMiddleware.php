<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class FirstSiteMiddleware
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
        $user=Auth::user();
        if(!is_null($user)) {
            $res = \App\Sites::where('my_company_id', $user->my_company_id)->where('is_deleted',0)->get();
            if (count($res) == 1) {



            }
            if (count($res) == 0) {

                if (\Request::url() != 'https://cloud.neiros.ru/setting/sites/create') {
                    return redirect('/setting/sites/create');
                }

            }
        }
        return $next($request);
    }
}

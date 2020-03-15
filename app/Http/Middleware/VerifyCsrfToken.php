<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = ['/setting*','/api*','/ajax/set_sites','/chat/*','/aster','/send_chat*','/get_tek_tema','/*','/allreports/*','/setting/users/getajaxuser*','/setting/users/saveajaxuser*','/advertisingchannel/delete1*'
        //
    ];
}

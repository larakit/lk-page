<?php
/**
 * Created by PhpStorm.
 * User: berdnikov
 * Date: 27.04.16
 * Time: 20:49
 */

namespace Larakit\Page;

use Closure;

class PageMiddlewareAfter {

    public function handle($request, Closure $next) {
        $response = $next($request);

        //Регистрация тем оформления
        $page_custom_file = app_path('Http/page.php');
        if(file_exists($page_custom_file)) {
            require_once $page_custom_file;
        }

        return $response;
    }
}
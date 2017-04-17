<?php
/**
 * Created by PhpStorm.
 * User: koksharov
 * Date: 07.10.16
 * Time: 16:36
 */

namespace Larakit\Page;

class LarakitServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function register() {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'lk-page');
        $this->publishes([
            __DIR__ . '/../../views' => resource_path('views/vendor/lk-page'),
        ]);

    }
}
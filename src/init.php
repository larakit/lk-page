<?php
//регистрируем сервис-провайдер
Larakit\Boot::register_provider('Larakit\Page\LarakitServiceProvider');

//регистрируем алиасы
\Larakit\Boot::register_alias('LaraPage', \Larakit\Page\Facade\Page::class);
\Larakit\Boot::register_alias('LaraPageHead', 'Larakit\Page\Facade\PageHead');

//регистрируем twig-функции
\Larakit\Twig::register_function('larakit_page_h1', function ($route = null) {
    return LaraPage::pageH1($route);
});
\Larakit\Twig::register_function('larakit_page_h1_ext', function ($route = null) {
    return LaraPage::pageH1Ext($route);
});
\Larakit\Twig::register_function('larakit_page_title', function () {
    return LaraPage::getTitle();
});
\Larakit\Twig::register_function('larakit_page_breadcrumbs', function () {
    return LaraPage::getBreadCrumbs();
});
\Larakit\Twig::register_function('larakit_route_icons', function ($route = null) {
    return Larakit\Route\Route::routeIcons($route);
});

Larakit\Boot::register_middleware(Larakit\Page\PageMiddleware::class);
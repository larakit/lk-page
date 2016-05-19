<?php
/*################################################################################
//регистрируем сервис-провайдер
################################################################################*/
Larakit\Boot::register_middleware(Larakit\Page\PageMiddleware::class);
Larakit\Boot::register_view_path(__DIR__.'/views', 'lk-page');

//######################################################################
// регистрируем функции
//######################################################################
if(!function_exists('larakit_page_body_attributes')) {
    function larakit_page_body_attributes() {
        return \Larakit\Page\Page::body()->getAttributes(true);
    }
}
Larakit\Twig::register_function('larakit_page_body_attributes', function () {
    return larakit_page_body_attributes();
});
if(!function_exists('larakit_page_head')) {
    function larakit_page_head() {
        $ret   = [];
        $ret[] = PHP_EOL.sprintf('        <title>%s</title>',\Larakit\Page\Page::getTitle());
        foreach(\Larakit\Page\PageMeta::$meta_plain as $k => $v) {
            $ret[] = (string) HtmlMeta::setAttribute($k, $v);
        }
        $ret[] = '';
        foreach(\Larakit\Page\PageMeta::$meta_name as $k => $v) {
            $ret[] = (string) HtmlMeta::setAttribute('name', $k)->setAttribute('content', $v);
        }
        $ret[] = '';
        foreach(\Larakit\Page\PageMeta::$meta_property as $k => $v) {
            $ret[] = (string) HtmlMeta::setAttribute('property', $k)->setAttribute('content', $v);
        }
        $ret[] = '';
        foreach(\Larakit\Page\PageMeta::$meta_http_equiv as $k => $v) {
            $ret[] = (string) HtmlMeta::setAttribute('http-equiv', $k)->setAttribute('content', $v);
        }
        $ret[]   = '';
        //favicon
//        \Larakit\Page\PageLink::add()->setRel('icon')->setHref(\Larakit\Page\Page::getFavicon());
        //domain sharding
        $domains = \Larakit\Page\PageDnsPrefetch::domains();
        if(count($domains)) {
            \Larakit\Page\PageMeta::meta_http_equiv('x-dns-prefetch-control', 'on');
            foreach($domains as $d) {
                \Larakit\Page\PageLink::add()->setRel('dns-prefetch')->setHref($d);
            }
        }
        foreach(\Larakit\Page\PageLink::$links as $link) {
            $ret[] = (string) $link;
        }
        $ret[] = '';
        $ret[] = trim(laracss());

        return '        ' . implode(PHP_EOL . '        ', $ret);
    }
}

Larakit\Twig::register_function('larakit_page_head', function () {
    return larakit_page_head();
});

Larakit\Twig::register_function('larakit_page_body', function () {
    return \Larakit\Page\Page::body();
});

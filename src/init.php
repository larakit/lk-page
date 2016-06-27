<?php
/*################################################################################
//регистрируем сервис-провайдер
################################################################################*/
Larakit\Boot::register_middleware(Larakit\Page\PageMiddleware::class);
Larakit\Boot::register_provider(\Larakit\Page\LarakitServiceProvider::class);
Larakit\Boot::register_alias('LaraPage', 'Larakit\Page\Facade\Page');
Larakit\Boot::register_alias('LaraPageHead', 'Larakit\Page\Facade\PageHead');

//\Larakit\Widget\ManagerWidget::register(\Larakit\Widget\WidgetBreadcrumbs::class,'');
\Larakit\Twig::register_function('larakit_page_h1', function(){

   \Larakit\Event\Event::listener('lk-page::titles', function($event, $titles){
      dd(func_get_args());
   });
   return LaraPage::getTitle(); 
});


//if(!function_exists('larakit_page_head')) {
//    function larakit_page_head() {
//        $ret   = [];
//        return '        ' . implode(PHP_EOL . '        ', $ret);
//        $ret[] = PHP_EOL.sprintf('        <title>%s</title>',\Larakit\Page\Page::getTitle());
//        $ret[] = (string) \Larakit\Page\Page::base();
//        foreach(\Larakit\Page\PageMeta::$meta_plain as $k => $v) {
//            $ret[] = (string) HtmlMeta::setAttribute($k, $v);
//        }
//        $ret[] = '';
//        foreach(\Larakit\Page\PageMeta::$meta_name as $k => $v) {
//            $ret[] = (string) HtmlMeta::setAttribute('name', $k)->setAttribute('content', $v);
//        }
//        $ret[] = '';
//        foreach(\Larakit\Page\PageMeta::$meta_property as $k => $v) {
//            $ret[] = (string) HtmlMeta::setAttribute('property', $k)->setAttribute('content', $v);
//        }
//        $ret[] = '';
//        foreach(\Larakit\Page\PageMeta::$meta_http_equiv as $k => $v) {
//            $ret[] = (string) HtmlMeta::setAttribute('http-equiv', $k)->setAttribute('content', $v);
//        }
//        $ret[]   = '';
//        foreach(\Larakit\Page\PageLink::$links as $link) {
//            $ret[] = (string) $link;
//        }
//        $ret[] = '';
//        $ret[] = trim(laracss());
//
//        return '        ' . implode(PHP_EOL . '        ', $ret);
//    }
//}

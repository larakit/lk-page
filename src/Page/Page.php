<?php
namespace Larakit\Page;

use Larakit\Widget\WidgetBreadcrumbs;
use Larakit\Widget\WidgetH1;

class Page {

    static protected $values = [
        'viewport'   => 'width=device-width, initial-scale=1.0',
        'charset'    => 'utf-8',
        'http_equiv' => 'IE=edge,chrome=1',
    ];
    static protected $body;

    static function addBreadCrumb($title, $url = '#') {
        WidgetBreadcrumbs::factory()->addItem($title, $url);
        WidgetH1::factory()->setH1($title);
        if(Webconfig::get('breadcrumb.explode')) {
            self::title(WidgetBreadcrumbs::factory()->getTitle());
        } else {
            self::title($title);
        }
    }

    static function page_data() {
        self::$values['body_attributes'] = self::body()->getAttributes(true);

        return self::$values;
    }

    static function _($key, $value = null, $overwrite = false) {
        if($value || $overwrite) {
            self::$values[$key] = $value;
        }

        return Arr::get(self::page_data(), $key);
    }

    static function viewport($value = null) {
        return self::_(__FUNCTION__, $value);
    }

    static function charset($value = null) {
        return self::_(__FUNCTION__, $value);
    }

    static function http_equiv($value = null) {
        return self::_(__FUNCTION__, $value);
    }

    static function title($value = null) {
        return self::_(__FUNCTION__, $value);
    }

    /**
     * @return \Larakit\Html\Body
     */
    static function body() {
        if(!self::$body) {
            self::$body = \HtmlBody::addClass('');
        }

        return self::$body;
    }

    /**
     * Доменный шардинг
     * @param $domain
     */
    static function dnsPrefetch($domain) {
        PageMeta::meta_http_equiv('x-dns-prefetch-control', 'on');
        self::addLink()->setRel('dns-prefetch')->setHref($domain);
    }

}
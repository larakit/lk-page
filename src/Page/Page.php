<?php
namespace Larakit\Page;

use Illuminate\Support\Arr;
use Larakit\Widget\WidgetBreadcrumbs;
use Larakit\Widget\WidgetH1;

class Page {

    static protected $values  = [
        'viewport'   => 'width=device-width, initial-scale=1.0',
        'charset'    => 'utf-8',
        'http_equiv' => 'IE=edge,chrome=1',
    ];
    static protected $body;
    static private $title;
    static protected $favicon = '/favicon.ico';

    static function addBreadCrumb($title, $url = '#') {
        WidgetBreadcrumbs::factory()->addItem($title, $url);
        WidgetH1::factory()->setH1($title);
//        if(Webconfig::get('breadcrumb.explode')) {
        if(1) {
//            dump('My title: '. self::getTitle());
            self::setTitle(WidgetBreadcrumbs::factory()->getTitle());
//            dump('new title: '. self::getTitle());
        } else {
            self::setTitle($title);
        }
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

    static function getTitle() {
//        dump(__FILE__.':'.__LINE__. ' ['.__METHOD__.']');
//        dump(static::$title);
//        dump(get_called_class());
        if(!self::$title) {
            return \Request::getHost();
        }

        return self::$title;
    }

    static function setTitle($value) {
//        dump(__FILE__.':'.__LINE__. ' ['.__METHOD__.']');
        self::$title = $value;
//        laratrace($value);
//        dump(self::$title);
        PageMeta::meta_property('og:title', $value);
        PageMeta::meta_name('twitter:title', $value);
    }

    static function setAuthor($value) {
        PageMeta::meta_name('author', $value);
    }

    static function setDescription($value) {
        PageMeta::meta_name('description', $value);
        PageMeta::meta_property('og:description', $value);
        PageMeta::meta_name('twitter:description', $value);
    }

    static function setKeywords($value) {
        PageMeta::meta_name('keywords', $value);
        PageMeta::meta_property('og:keywords', $value);
    }

    static function setUrl($value) {
        PageMeta::meta_property('og:url', $value);
        PageMeta::meta_name('twitter:keywords', $value);
        PageLink::add()->setRel('canonical')->setAttribute('href', $value);
    }

    static function setSitename($value) {
        PageMeta::meta_property('og:site_name', $value);
    }

    static function setVerificationYandex($value) {
        PageMeta::meta_name('yandex-verification', $value);
    }

    static function setVerificationGoogle($value) {
        PageMeta::meta_name('google-site-verification', $value);
    }

    static function setAppleTouchIcon($value) {
        return PageLink::add()->setRel('apple-touch-icon')->setHref($value);
    }

    static function setAppleTouchIcon76($value) {
        self::setAppleTouchIcon($value)->setAttribute('sizes', '76x76');
    }

    static function setAppleTouchIcon120($value) {
        self::setAppleTouchIcon($value)->setAttribute('sizes', '120x120');
    }

    static function setAppleTouchIcon152($value) {
        self::setAppleTouchIcon($value)->setAttribute('sizes', '152x152');
    }

    static function setFavicon($value) {
        self::$favicon = $value;
    }
    static function getFavicon() {
        return self::$favicon;
    }

    /**
     * OpenGraph: image
     *
     * @param $src
     */
    static function setImage($src) {
        PageLink::add()->setRel('image_src')->setAttribute('href', $src);
        PageMeta::meta_property('og:image', $src);
    }

}

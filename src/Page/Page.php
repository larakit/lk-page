<?php
namespace Larakit\Page;

use Larakit\Event\Event;
use Larakit\Html\Base;
use Larakit\Html\Body;
use Larakit\Widget\WidgetBreadcrumbs;
use Larakit\Widget\WidgetH1;

class Page {

    protected $title;
    protected $breadcrumbs = [];
    /**
     * @var Body
     */
    protected $body;

    /**
     * @var Base
     */
    protected $base;

    protected $favicon      = '/favicon.ico';
    protected $dns_prefetch = [];
    protected $apple_icons  = [];
    protected $image;
    protected $charset      = 'utf-8';

    function __construct() {
        $this->body = new Body();
        $this->base = new Base();
    }

    /**
     * Добавим собранный layout
     *
     * @param $content
     */
    function setContent($content) {
        $this->body->setContent($content);

        return $this;
    }

    /**
     * Установим базовый href страницы
     *
     * @param $href
     *
     * @return $this
     */
    function setBaseHref($href) {
        $this->base->setHref($href);

        return $this;
    }

    /**
     * Установим базовый target страницы
     *
     * @param $target
     *
     * @return $this
     */
    function setBaseTarget($target) {
        $this->base->setTarget($target);

        return $this;
    }

    function getBreadCrumbs() {
        return $this->breadcrumbs;
    }
    function addBreadCrumb($route_name, $params = []) {
        $this->breadcrumbs[route($route_name, $params)] = $params;

        return $this;
        $url = route($route_name, $params);
        WidgetBreadcrumbs::factory()->addItem($route_name);
        WidgetH1::factory()->setH1($title);
//        if(Webconfig::get('breadcrumb.explode')) {
        if(1) {
            self::setTitle(WidgetBreadcrumbs::factory()->getTitle());
        } else {
            self::setTitle($title);
        }
    }

    function addDnsPrefetch($url) {
        $url                      = parse_url($url, PHP_URL_HOST);
        $this->dns_prefetch[$url] = $url;

        return $this;
    }

    function getDnsPrefetch() {
        return $this->dns_prefetch;
    }

    /**
     * Указать автора
     *
     * @param $value
     *
     * @return $this
     */
    function setAuthor($value) {
        \LaraPageHead::addMetaName('author', $value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function setDescription($value) {
        PageMeta::meta_name('description', $value);
        PageMeta::meta_property('og:description', $value);
        PageMeta::meta_name('twitter:description', $value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function setKeywords($value) {
        PageMeta::meta_name('keywords', $value);
        PageMeta::meta_property('og:keywords', $value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function setUrl($value) {
        PageMeta::meta_property('og:url', $value);
        PageMeta::meta_name('twitter:keywords', $value);
        PageLink::add(__METHOD__)->setRel('canonical')->setAttribute('href', $value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function setSitename($value) {
        PageMeta::meta_property('og:site_name', $value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function setVerificationYandex($value) {
        PageMeta::meta_name('yandex-verification', $value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function setVerificationGoogle($value) {
        PageMeta::meta_name('google-site-verification', $value);

        return $this;
    }

    function getAppleTouchs() {
        return $this->apple_icons;
    }

    function setAppleTouchIcon76($value) {
        $this->setAppleTouchIcon($value, 76);
    }

    function setAppleTouchIcon($value, $size = null) {
        $this->apple_icons[$size] = $value;

        return $this;

        return PageLink::add(__METHOD__ . $size)->setRel('apple-touch-icon')->setHref($value);
    }

    function setAppleTouchIcon120($value) {
        $this->setAppleTouchIcon($value, 120);
    }

    function setAppleTouchIcon152($value) {
        $this->setAppleTouchIcon($value, 152);
    }

    /**
     * @return mixed
     */
    function getFavicon() {
        return $this->favicon;
    }

    function setFavicon($value) {
        $this->favicon = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getCharset() {
        return $this->charset;
    }

    /**
     * @param string $charset
     *
     * @return Page;
     */
    public function setCharset($charset) {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return Page;
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    protected $x_ua_compatible = 'IE=edge,chrome=1';
    protected $viewport        = 'width=device-width, initial-scale=1.0';
    protected $generator       = 'Larakit (https://github.com/larakit)';

    /**
     * @return string
     */
    public function getGenerator() {
        return $this->generator;
    }

    /**
     * @param string $generator
     *
     * @return Page;
     */
    public function setGenerator($generator) {
        $this->generator = $generator;

        return $this;
    }

    /**
     * @return string
     */
    public function getViewport() {
        return $this->viewport;
    }

    /**
     * @param string $viewport
     *
     * @return Page;
     */
    public function setViewport($viewport) {
        $this->viewport = $viewport;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getXUaCompatible() {
        return $this->x_ua_compatible;
    }

    /**
     * @param mixed $x_ua_compatible
     *
     * @return Page;
     */
    public function setXUaCompatible($x_ua_compatible) {
        $this->x_ua_compatible = $x_ua_compatible;

        return $this;
    }

    function __toString() {
        try {
            $title           = $this->getTitle();
            $base            = $this->base;
            $layout          = $this->body->getContent();
            $body_attributes = $this->body->getAttributes(true);
            $meta_tags       = Event::filter('lk-page::meta-tags', []);

            return \View::make('lk-page::page', compact(
                'base',
                'body_attributes',
                'title',
                'layout',
                'meta_tags'
            ))->render();
        }
        catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getTitle() {
        trans('seo.'.\Route::currentRouteName());
        return Event::filter('lk-page::title', $this->title ? : 'title');
    }

    /**
     * @param mixed $title
     *
     * @return Page;
     */
    public function setTitle($title) {
        $this->title = $title;
        \LaraPageHead::addMetaProperty('og:title', $title);
        \LaraPageHead::addMetaName('twitter:title', $title);
        return $this;
    }

    protected $og_title;
    protected $og_locale = 'ru_RU';


}

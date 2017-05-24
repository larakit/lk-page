<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 24.05.17
 * Time: 10:26
 */

namespace Larakit\Page;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Larakit\Html\Body;
use Larakit\Html\Html;
use Larakit\StaticFiles\Css;
use Larakit\StaticFiles\Js;

class LkPage {
    
    protected $html;
    protected $head = [
        'viewport'     => 'width=device-width, initial-scale=1.0',
        'generator'    => 'Larakit (https://github.com/larakit)',
        'dns_prefetch' => [],
        'compatible'   => 'IE=edge,chrome=1',
        'base'         => '/',
        'favicon'      => '/favicon.ico',
        'charset'      => 'utf-8',
        'rss'          => [],
    ];
    protected $body;
    static    $instance;
    
    static function instance() {
        if(!isset(self::$instance)) {
            self::$instance = new LkPage();
        }
        
        return self::$instance;
    }
    
    function __construct() {
        $this->html = new Html();
        $this->html->setAttribute('lang', \App::getLocale());
        $this->body = new Body();
    }
    
    function body() {
        return $this->body;
    }
    
    function html() {
        return $this->html;
    }
    
    /**
     * Получить список доступных для выбора тем оформления
     *
     * @return array|mixed
     */
    function getThemes() {
        $themes = env('PAGE_THEMES');
        $themes = explode(' ', $themes);
        
        return $themes;
    }
    
    /**
     * Установить текущую тему оформления
     *
     * @param $theme
     *
     * @return $this
     */
    function setTheme($theme) {
        $themes = $this->getThemes();
        foreach($themes as $_theme) {
            $this->body->removeClass('theme--' . $_theme);
        }
        $this->body->addClass('theme--' . $theme);
        
        return $this;
    }
    
    /**
     * Задать содержимое страницы
     *
     * @param $content
     */
    function setBodyContent($content) {
        $this->body->setContent($content);
        
        return $this;
    }
    
    protected function setHead($k, $v) {
        $k              = mb_substr($k, 7);
        $k              = Str::snake($k);
        $this->head[$k] = $v;
        
        return $this;
    }
    
    /**
     * Установка заголовка страницы
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadTitle($v) {
        return $this->setHead(__FUNCTION__, $v);
        
    }
    
    /**
     * Установка вьюпорта
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadViewport($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    /**
     * Установка кейвордов
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadKeywords($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    /**
     * Установка описания страницы
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadDescription($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    function setHeadDnsPrefetch($url) {
        $url                              = parse_url($url, PHP_URL_HOST);
        $this->head['dns_prefetch'][$url] = '//' . $url;
        
        return $this;
    }
    
    function setHeadRobots($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    /**
     * разрешено индексировать текст и ссылки на странице, аналогично <meta name="robots" content="index, follow"/>
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadRobotsAll() {
        return $this->setHeadRobots('all');
    }
    
    /**
     * не индексировать текст страницы,
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadRobotsNoIndex() {
        return $this->setHeadRobots('noindex');
    }
    
    /**
     *  не переходить по ссылкам на странице,
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadRobotsNoFollow() {
        return $this->setHeadRobots('nofollow');
    }
    
    /**
     * запрещено индексировать текст и переходить по ссылкам на странице, аналогично <meta name="robots" content="noindex, nofollow"/>
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadRobotsNone() {
        return $this->setHeadRobots('none');
    }
    
    /**
     *  не показывать ссылку на сохраненную копию на странице результатов поиска.
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadRobotsNoArchive() {
        return $this->setHeadRobots('noarchive');
    }
    
    /**
     * не использовать описание из Яндекс.Каталога для сниппета в результатах поиска.
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadRobotsNoYaca() {
        return $this->setHeadRobots('noyaca');
    }
    
    /**
     * Установка режима совместимости
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadCompatible($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    function setHeadVideo($url, $w = null, $h = null) {
        return $this->setHead(__FUNCTION__, compact('url', 'w', 'h'));
    }
    
    /**
     * название сайта, на котором размещена информация об объекте.
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadSiteName($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    /**
     * URL изображения, описывающего объект (соответствует og:image).
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadImage($url, $w = null, $h = null) {
        $host   = parse_url($url, PHP_URL_HOST);
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if(!$host) {
            $host = \Request::getHost();
        }
        if(!$scheme) {
            $scheme = \Request::getScheme();
        }
        $path                      = parse_url($url, PHP_URL_PATH);
        $url                       = $scheme . '://' . $host . $path;
        $this->head['image'][$url] = compact('url', 'w', 'h');
        
        return $this;
    }
    
    function setHeadRss($url) {
        $this->head['rss'][$url] = $url;
        
        return $this;
    }
    
    function setHeadBase($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    function setHeadFavicon($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    function setHeadAppend($v) {
        $this->head['append'][$v] = $v;
        
        return $this;
    }
    
    /**
     * Указывает кодировку документа.
     *
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadCharset($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    /**
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadAuthor($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    /**
     * @param $v
     *
     * @return \Larakit\Page\LkPage
     */
    function setHeadCopyright($v) {
        return $this->setHead(__FUNCTION__, $v);
    }
    
    function __toString() {
        //HEAD
        $head   = [];
        $title  = isset($this->head['title']) ? $this->head['title'] : \Request::getHost();
        $head[] = '<!-- title -->';
        $head[] = '<title>' . $title . '</title>';
        $head[] = '<meta property="og:title" content="' . $title . '"/>';
        $head[] = '';
        
        $site_name = isset($this->head['site_name']) ? $this->head['site_name'] : \Request::getHost();
        $head[]    = '<!-- site_name -->';
        $head[]    = '<meta property="og:site_name" content="' . $site_name . '">';
        $head[]    = '';
        
        foreach($this->head as $k => $v) {
            if('base' == $k) {
                $head[] = '<!-- base -->';
                $head[] = '<base href="' . $v . '" />';
                $head[] = '';
            }
            if('charset' == $k) {
                $head[] = '<!-- charset -->';
                $head[] = '<meta charset="' . $v . '" />';
                $head[] = '<meta http-equiv="Content-Type" content="text/html; charset=' . $v . '" />';
                $head[] = '';
            }
            if('author' == $k) {
                $head[] = '<!-- author -->';
                $head[] = '<meta name="author" content="' . $v . '" />';
                $head[] = '';
            }
            if('copyright' == $k) {
                $head[] = '<!-- copyright -->';
                $head[] = '<meta name="copyright" content="' . $v . '" />';
                $head[] = '';
            }
            if('favicon' == $k) {
                $head[] = '<!-- favicon -->';
                $head[] = '<link rel="icon" href="' . $v . '">';
                $head[] = '';
            }
            if('viewport' == $k) {
                $head[] = '<!-- viewport -->';
                $head[] = '<meta name="viewport" content="' . $v . '" />';
                $head[] = '';
            }
            if('generator' == $k) {
                $head[] = '<!-- generator -->';
                $head[] = '<meta name="generator" content="' . $v . '" />';
                $head[] = '';
            }
            if('image' == $k) {
                $i = 0;
                foreach($v as $value) {
                    $i++;
                    $head[] = '<!-- image (' . $i . ') -->';
                    $url    = Arr::get($value, 'url');
                    $w      = Arr::get($value, 'w');
                    $h      = Arr::get($value, 'h');
                    $head[] = '<meta property="og:image" content="' . $url . '">';
                    if($w) {
                        $head[] = '<meta property="og:image:width" content="' . $w . '">';
                    }
                    if($h) {
                        $head[] = '<meta property="og:image:height" content="' . $h . '">';
                    }
                    $head[] = '';
                }
            }
            if('video' == $k) {
                $head[] = '<!-- video -->';
                $url    = Arr::get($v, 'url');
                $w      = Arr::get($v, 'w');
                $h      = Arr::get($v, 'h');
                $head[] = '<meta property="og:video" content="' . $url . '">';
                if($w) {
                    $head[] = '<meta property="og:video:width" content="' . $w . '">';
                }
                if($h) {
                    $head[] = '<meta property="og:video:height" content="' . $h . '">';
                }
                $head[] = '';
            }
            if('rss' == $k) {
                if(count($v)) {
                    $head[] = '<!-- rss -->';
                    foreach($v as $value) {
                        $head[] = '<link rel="alternate" type="application/rss+xml" href="' . $value . '" />';
                    }
                    $head[] = '';
                }
            }
            if('append' == $k) {
                $head[] = '<!-- append -->';
                foreach($v as $value) {
                    $head[] = $value;
                }
                $head[] = '';
            }
            if('keywords' == $k) {
                $head[] = '<!-- keywords -->';
                $head[] = '<meta name="og:keywords" content="' . $v . '" />';
                $head[] = '<meta name="twitter:keywords" content="' . $v . '" />';
                $head[] = '<meta name="keywords" content="' . $v . '" />';
                $head[] = '';
            }
            if('description' == $k) {
                $head[] = '<!-- description -->';
                $head[] = '<meta name="og:description" content="' . $v . '" />';
                $head[] = '<meta name="twitter:description" content="' . $v . '" />';
                $head[] = '<meta name="description" content="' . $v . '" />';
                $head[] = '';
            }
            if('compatible' == $k) {
                $head[] = '<!-- compatible -->';
                $head[] = '<meta http-equiv="X-UA-Compatible" content="' . $v . '" />';
                $head[] = '';
            }
            if('robots' == $k) {
                $head[] = '<!-- robots -->';
                $head[] = '<meta name="robots" content="' . $v . '" />';
                $head[] = '';
            }
            if('dns_prefetch' == $k) {
                if(count($v)) {
                    $head[] = '<!-- dns-prefetch" -->';
                    foreach($v as $value) {
                        $head[] = '<link rel="dns-prefetch" href="' . $value . '">';
                    }
                    $head[] = '';
                }
            }
        }
        $head[] = '<!-- url -->';
        $head[] = '<meta property="og:url" content="' . \URL::current() . '" />';
        $head[] = '';
        $head[] = '<!-- locale -->';
        $head[] = '<meta property="og:locale" content="' . \App::getLocale() . '" />';
        $head[] = '';
        $head[] = '<!-- css" -->';
        $head   = '<head>' . PHP_EOL . "\t\t" . implode(PHP_EOL . "\t\t", $head) . PHP_EOL;
        $head .= Css::instance();
        $head .= '</head>';
        
        //BODY
        $content = $this->body->getContent();
        $this->body->setContent(PHP_EOL . $content . PHP_EOL . Js::instance() . PHP_EOL);
        
        //HTML
        $this->html->setContent(PHP_EOL . $head . PHP_EOL . $this->body . PHP_EOL);
        
        return '<!DOCTYPE html>' . PHP_EOL . $this->html;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: berdnikov
 * Date: 27.04.16
 * Time: 20:03
 */

namespace Larakit\Page;

class PageMeta {

    static $meta_plain      = [
        'charset' => 'utf-8',
    ];
    static $meta_http_equiv = [
        'X-UA-Compatible' => 'IE=edge,chrome=1',
    ];
    static $meta_name       = [
        'viewport'  => 'width=device-width, initial-scale=1.0',
        'GENERATOR' => 'Larakit (https://github.com/larakit)',
    ];
    static $meta_property   = [
        'og:locale' => 'ru_RU',
    ];

    static function meta_plain($k, $v) {
        self::$meta_plain[$k] = $v;
    }

    static function meta_property($k, $v) {
        self::$meta_property[$k] = $v;
    }

    static function meta_name($k, $v) {
        self::$meta_name[$k] = $v;
    }

    static function meta_http_equiv($k, $v) {
        self::$meta_http_equiv[$k] = $v;
    }

    //    static function setMetaNameGenerator($content) {
    //        self::setMetaName('GENERATOR', $content);
    //    }

    /**
     * Кодировка
     * Чтобы сообщить браузеру, в какой кодировке находятся символы веб-страницы
     *
     * @param $v
     */
    static function charset($v) {
        self::meta_plain('charset', $v);
    }

    /**
     * SEO: description
     * Большинство поисковых серверов отображают содержимое поля description (пример 1) при выводе результатов поиска. Если этого тега нет на странице, то поисковый
     * движок просто перечислит первые встречающиеся слова на странице, которые, как правило, оказываются не очень-то и в тему.
     *
     * @param $v
     */
    static function description($v) {
        self::meta_name('description', $v);
    }

    /**
     * SEO: keywords
     * Этот метатег был предназначен для описания ключевых слов, встречающихся на странице (пример 2). Но в результате действия людей, желающих попасть в верхние строчки
     * поисковых систем любыми средствами, теперь дискредитирован. Поэтому многие поисковики пропускают этот параметр.
     *
     * @param $v
     */
    static function keywords($v) {
        self::meta_name('keywords', str_replace(',', ' ', $v));
    }

    /**
     * Идентификатор Facebook-application
     *
     * @param $v
     */
    static function fb_app_id($v) {
        self::meta_property('fb:app_id', $v);
    }
    static function url($v) {
        self::meta_property('og:url', \Request::url());
    }

    /**
     * Автозагрузка страниц
     * Этот метатег позволяет создавать перенаправление (редирект) на другой сайт. Если URL не указан, произойдет автоматическое обновление текущей страницы через
     * количество секунд, заданных в атрибуте content.
     *
     * @param      $delay
     * @param null $url
     */
    static function refresh($delay, $url = null) {
        $v = $delay;
        if($url) {
            $v .= '; URL=' . $url;
        }
        self::meta_http_equiv('refresh', $v);
    }
}
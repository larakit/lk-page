<?php
namespace Larakit\Page;

class Theme {
    static protected $current = null;

    static function get() {
        return self::$current;
    }

    static function set($theme) {
        self::$current = $theme;
    }
}

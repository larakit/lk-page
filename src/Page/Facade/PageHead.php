<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 09.06.16
 * Time: 11:52
 */

namespace Larakit\Page\Facade;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @author aberdnikov
 */
class PageHead extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return \Larakit\Page\PageHead
     *
     */
    static           $instance = null;
    protected static function getFacadeAccessor() {
        if(!self::$instance) {
            self::$instance = new \Larakit\Page\PageHead();
        }

        return self::$instance;
    }

}
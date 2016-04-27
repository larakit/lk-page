<?php
\Larakit\Twig::register_function('page_data', function($name = null){
    return \Larakit\Page\Page::_($name);
});
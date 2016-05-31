<?php
namespace Larakit;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController {

    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $model_name;
    protected $base_url;
    protected $layout = null;
    protected $page   = 'lk-page::page';

    function response($vars = []) {
        if(!isset($vars['base_url'])) {
            $vars['base_url'] = $this->base_url;
        }
        $layout = \View::make($this->getLayout(), $vars);
        return \View::make(
            $this->page,
            [
                'layout' => $layout,
            ]
        );
    }

    /**
     * @param $tpl
     *
     * @return $this
     */
    function setLayout($tpl = null) {
        if(!is_null($tpl)) {
            $this->layout = $tpl;
        }

        return $this;
    }

    function getLayout() {
        return $this->layout ? : \Route::currentRouteName();
    }

}

<?php
namespace Larakit;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Larakit\Page\LkPage;

class Controller extends BaseController {
    
    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;
    
    protected $layout = null;
    
    function responseContent($content) {
        return $this->response(compact('content'));
    }
    
    function response($vars = []) {
        $layout = \View::make($this->getLayout(), $vars);
        
        return LkPage::instance()->setBodyContent($layout);
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

<?php
namespace KSPM\LCMS\Controllers;

use KSPM\LCMS\Service\ModuleService as ModuleService;

class BaseController extends \Illuminate\Routing\Controller {

    public function __construct() {
        $this->beforeFilter('@auth');
        \View::share('module_defintion', ModuleService::getInstance()->getBackendModules());
        
        $reflectionClass = new \ReflectionClass(get_called_class());
        $moduleName = $this->_fromCamelCase($reflectionClass->getShortName());
        \View::share('current_module', lcfirst($moduleName));
        \View::share('cmsprefix', _JBKCMS_PREFIX_);
        \View::share('coremodules', config('laikacms.default.core-modules'));
    }

    public function auth(\Illuminate\Routing\Route $route, $request) {
        $action = explode('@', $route->getActionName());
       
        $whiteList = ['showLogin', 'loginAction', 'logoutAction'];
        if (\Session::get('cmslogin') == null && (!in_array($action[1], $whiteList))) {
            return \Redirect::to('/'._JBKCMS_PREFIX_.'/login');
        }
    }
    
    public function deploy(){
            var_dump(__METHOD__);
            return \Artisan::call('laikacms:deploy', []);
            
        }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = \View::make($this->layout);
        }
    }

    private function _fromCamelCase($camelCaseString) {
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, $camelCaseString);
        return $a[0];
    }

}

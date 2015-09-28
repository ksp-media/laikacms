<?php

namespace KSPM\LCMS\Controllers;

class MainController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    protected $layout = 'laikacms::layouts.default';

   
    public function setupLayout() {
        parent::setupLayout();
    }

    public function showIndex() {
        return \View::make('laikacms::base.index', array());
    }

    public function showLogin() {
        return \View::make('laikacms::base.login', array());
    }

    public function loginAction() {

        if ($_POST['user']['email'] && $_POST['user']['password']) {
            $user = \KSPM\LCMS\Model\User::where('email', '=', $_POST['user']['email'])->where('password', '=', md5($_POST['user']['password']))->first();
            if ($user) {
                \Session::put('cmslogin', true);
               return \Redirect::away("/"._JBKCMS_PREFIX_."/");
            } else {
              return  \Redirect::to('/'._JBKCMS_PREFIX_.'/login')->with('message', 'Login Failed: user not found');
            }
        } else {
           return \Redirect::away('/'._JBKCMS_PREFIX_.'/login')->with('message', 'Login Failed');
        }
    }
    
    public function logoutAction() {
        \Session::forget('cmslogin');
        return \Redirect::away('/'._JBKCMS_PREFIX_.'/login');
    }

}

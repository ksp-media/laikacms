<?php

namespace KSPM\LCMS\Controllers;

class InstallController extends BaseController {
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

   
    public function setupLayout() {
        parent::setupLayout();
    }

    public function showInstall() {
        return \View::make('laikacms::base.install', array());
    }

}

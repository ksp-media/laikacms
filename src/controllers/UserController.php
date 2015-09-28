<?php

namespace KSPM\LCMS\Controllers;

class UserController extends BaseController {
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
        return \View::make('laikacms::user.list', array('users' => \KSPM\LCMS\Model\User::all()));
    }
    
    public function showForm($id) {
        if($id != "new"){
            $user = \KSPM\LCMS\Model\User::find($id);
        }else{
            $user = false;
        }
        return \View::make('laikacms::user.modals.form', array('user' => $user, 'roles' => \KSPM\LCMS\Model\UserRole::all()));
    }
    
    public function saveForm(){
        $data = $_POST['user'];
        if($data['password'] == null){
            unset($data['password']);
        }else{
            $data['password'] = md5($data['password']);
        }
        
        $data['id'] = (array_has($data, 'id')) ? $data['id'] : false;
       
        $user = \KSPM\LCMS\Model\User::updateOrCreate(['id' => $data['id']], $data);
        return json_encode($user);
    }

    

}

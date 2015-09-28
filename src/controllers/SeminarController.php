<?php

namespace KSPM\LCMS\Controllers;

class SeminarController extends BaseController {
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

    protected $layout = 'laikacms::layouts.seminar';

    public function setupLayout() {
        parent::setupLayout();
    }

    public function listAction() {
        $seminare = \Seminar::all();
        return \View::make('laikacms::seminar.list', array('seminare' => $seminare));
    }

    public function showEditForm($id) {
        $seminar = \Seminar::find($id);
        return \View::make('laikacms::seminar.edit', array('seminar' => $seminar, 'categories' => \Category::seminarCategories()->get()));
    }

    public function showCreateForm() {
        return \View::make('laikacms::seminar.edit', array('seminar' => \Seminar::create(array()), 'categories' => \Category::seminarCategories()->get()));
    }

    public function saveAction() {
        if (key_exists('id', $_POST['seminar'])) {
            $seminar = \Seminar::find((int) $_POST['seminar']['id']);
        }

        if (!$seminar) {
            $seminar = \Seminar::create(array());
        }

        if (key_exists('category', $_POST['seminar'])) {


            foreach (\Category::all() as $category) {
                if (in_array($category->id, $_POST['seminar']['category'])) {
                    $vals = [
                        'trilogie_seminar_entry_id' => $seminar->id,
                        'trilogie_seminar_category_id' => $category->id
                    ];
                    \SeminarCategory::updateOrCreate($vals, $vals);
                } else {
                    $s = \SeminarCategory::where('trilogie_seminar_entry_id', '=', $seminar->id)
                                    ->where('trilogie_seminar_category_id', '=', $category->id)->first();
                    if ($s)
                        $s->delete();
                }
            }

            unset($_POST['seminar']['category']);
        }
        

           
        if (key_exists('date', $_POST['seminar'])) {
            foreach ($_POST['seminar']['date'] as $key => $pDate) {
                $pDate['triologie_seminar_entry_id'] = $seminar->id;
                $pDate['actionprice'] = (key_exists('actionprice', $pDate)) ? 1 : 0;
                $pDate['is_active'] = (key_exists('is_active', $pDate)) ? 1 : 0;
                \SeminarDate::updateOrCreate(array('id' => (int) $key), $pDate);
            }
        }


        unset($_POST['seminar']['date']);

        $keys = ['active', 'price_is_offer', 'category_highlight', 'start_highlight'];
        foreach ($keys as $k) {
            $_POST['seminar'][$k] = (key_exists($k, $_POST['seminar'])) ? true : false;
        }

        if (key_exists('deleted-dates', $_POST['seminar'])) {
            $ids = explode(',', $_POST['seminar']['deleted-dates']);
            foreach ($ids as $id) {
                $date = \SeminarDate::find($id);
                if ($date) {
                    $date->delete();
                }
            }
        }
        unset($_POST['seminar']['deleted-dates']);

        $seminar->update($_POST['seminar']);
        return \Redirect::to("/laikacms/seminar/{$seminar->id}/edit")->with('message', 'Seminar succesfully updated now');
    }
    
    
    public function deleteItemAction($id){
        $s = \Seminar::find($id);
        if($s) {
            $s->delete();
        }
        return \Redirect::to("/laikacms/seminare")->with('message', 'Seminar succesfully deleted');
    }

}

<?php

namespace KSPM\LCMS\Controllers;

class CmsController extends BaseController {
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

    protected $layout = 'laikacms::layouts.pages';
    

    public function __construct() {
        parent::__construct();
        \View::share('pageTree', \KSPM\LCMS\Model\Page::getPageTree());
    }


    public function setupLayout() {
        parent::setupLayout();

       // \View::share('current_module', 'cms');
    }

    public function listAction() {
        return \View::make('laikacms::cms.list', array('contents' => \KSPM\LCMS\Model\Content::all(), 'current_module' => "content"));
    }
    
    public function createAction(){
        \KSPM\LCMS\Model\Content::updateOrCreate(['key' => $_POST['content']['key']], $_POST['content']);
        return json_encode(array('status' => true));
    }
    
    public function clearCacheAction(){
        $compiled_path = rtrim(storage_path('framework/views/'));
        array_map('unlink', glob("{$compiled_path}*"));
        \Cache::flush();
        \KSPM\LCMS\Model\SlugCache::truncate();
        return json_encode(array('status' => true));
    }
    
    public function listPagesShow(){
        return \View::make('laikacms::cms.pages.list', array('contents' => \KSPM\LCMS\Model\Page::all()));
    }
    
    public function showCreatePageForm(){
        $page = \KSPM\LCMS\Model\Page::create(array());
        $service = new \KSPM\LCMS\Service\TagParserService($page->template, $page->content);
        return \View::make('laikacms::cms.pages.form', array('page' => $page, 'content' => $service->getResult()));
    }
    
    public function showEditPageForm($id){
        $page = \KSPM\LCMS\Model\Page::find($id);
        $service = new \KSPM\LCMS\Service\TagParserService($page->template, $page->content);
        return \View::make('laikacms::cms.pages.form', array('page' => $page, 'content' => $service->getResult()));
    }
	
    public function deletePageAction($id){
        $page = \KSPM\LCMS\Model\Page::find($id);
        $page->delete();
        return \Redirect::to("/"._LCMS_PREFIX_."/cms/pages")->with('message', 'page not deleted ...');
    }
    
    public function savePageAction(){
        if (key_exists('id', $_POST['page'])) {
            $page = \KSPM\LCMS\Model\Page::find((int) $_POST['page']['id']);
        }else{
            return \Redirect::to("/"._LCMS_PREFIX_."/cms/pages")->with('message', 'page not found!');
        }
        if($page){
            $data = $_POST['page'];
            if(!$data['slug']){
                $data['slug'] = \KSPM\LCMS\Helper\GlobalHelper::generateSlugFromString($data['title']) . '.html';
            }
            if( key_exists('content', $data)){
                $service = new \KSPM\LCMS\Service\TagParserService($page->template, serialize($data['content']));
                $data['compiled_template'] =  $service->render();
                $data['content'] = serialize($data['content']);
            }
            
            $page->update($data);
            return \Redirect::to("/"._LCMS_PREFIX_."/cms/page/{$page->id}/edit")->with('message', 'Page succesfully updated now');
        }else{
            return \Redirect::to("/"._LCMS_PREFIX_."/cms/pages")->with('message', 'page not found!');
        }
        
        
    }

    public function updateTreeAction(){
        $this->_updateTreeItemPosition(\Request::get('pagetree'), 0);
    }
    
    private function _updateTreeItemPosition($childs, $parentId) {
        $pos = 0;
        foreach ($childs as $item) {
            \KSPM\LCMS\Model\Page::find($item['id'])->update(['position' => $pos, 'parent' => $parentId]);
            if (key_exists('children', $item)) {
                $this->_updateTreeItemPosition($item['children'], $item['id']);
            }
            $pos++;
        }
    }
    
    

}
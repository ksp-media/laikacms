<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_page';
    protected $primaryKey = 'id';
    protected $guarded = array();
    
    public static function getPageTree(){
        $data = [];
        $i = 0;
        $roots = Page::where('parent', '=', 0)->get();
        foreach($roots as $page){
            $data[$i] = $page;
            $data[$i]['childs'] = self::_getChildsByPageId($page->id);
            $i++;
        }
        
        return $data;
    }
    
    private static function _getChildsByPageId($pageId){
        $data = [];
        $i = 0;
        $pages = Page::where('parent', '=', $pageId)->get();
        foreach($pages as $page){
            $data[$i] = $page;
            $data[$i]['childs'] = self::_getChildsByPageId($page->id);
            $i++;
        }
        
        return (count($data)>0)?$data:false;
    }

    public function pageIsInPath($page){
        
        if($this->id == $page->id){
            return true;
        }
        if($page->parent == $this->id){
            return true;
        }
            
        return false; 

    }
    
    public function hasChilds(){
        return (Page::where('parent', '=', $this->id)->count() > 0)?true:false;
    }
    
    public function childs(){
        return Page::where('parent', '=', $this->id)->orderBy('position')->get();
    }
    
    public function getObjects($obj, $filter = false){
        return \Module\Objects\Service\CmsService::get()->result($obj, $filter);
    }
    
    public static function htmlTree(){
        $page = new self;
        return '<ol class="dd-list">' . $page->_getTreeData(Page::where('parent', '=', 0)->orderBy('position')->get()) . '</ol>';
    }
    
    /**
     * @param type $data
     * @param type $html
     * @return string
     */
    private function _getTreeData($data) {
        $html = "";
        foreach ($data as $item) {
            $html .= '<li data-parent-id="'.$item->parent.'" data-id="' . $item->id. '" class="dd-item">';
            $html .= $this->_compileMainTreeHTML($item);
            if($item->hasChilds()){
                $html .= '<ol class="dd-list">';
                $html .= $this->_getTreeData($item->childs());
                $html .= '</ol>';
            }
            $html .= '</li>';
        }
        
        return $html;
    }

    private function _compileMainTreeHTML($data) {
        $html = '<div class="dd-handle" >
                                        <i class="fa fa fa-file-text-o"></i> 
                                        
                                    </div><div class="dd-content"><span class="tree-item" data-id="##id##">##title##</span></div>';
        return str_replace('##title##', $data->title, str_replace('##id##', $data->id, $html));
    }
    
}

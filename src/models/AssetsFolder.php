<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class AssetsFolder extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_assets_folder';
    protected $primaryKey = 'id';
    protected $guarded = array();
    
    
    public static function folders($parent = 0){
        return AssetsFolder::where('parent_id', '=', $parent)->orderBy('name')->get();
    }
    
    public function files(){
        return $this->hasMany('\KSPM\LCMS\Model\AssetsFile', 'folder_id', 'id');
    }
    
     public function hasChilds(){
        return (static::where('parent_id', '=', $this->id)->count() > 0)?true:false;
    }
    
    public function childs(){
        return static::where('parent_id', '=', $this->id)->get();
    }

     public static function htmlTree(){
        $folder = new self;
        return '<ol class="dd-list">' . $folder->_getTreeData(AssetsFolder::where('parent_id', '=', 0)->orderBy('position')->get()) . '</ol>';
    }
    
    /**
     * @param type $data
     * @param type $html
     * @return string
     */
    private function _getTreeData($data) {
        $html = "";
        foreach ($data as $item) {
            $html .= '<li data-parent-id="'.$item->parent_id.'" data-id="' . $item->id. '" class="dd-item">';
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
        return str_replace('##title##', $data->name, str_replace('##id##', $data->id, $html));
    }
    

}

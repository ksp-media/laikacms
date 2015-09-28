<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class AssetsFolder extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jbkcms_assets_folder';
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

    

}

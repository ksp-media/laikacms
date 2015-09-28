<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class SlugCache extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_slug_table';
    protected $primaryKey = 'id';
    protected $fillable = array('slug', 'base_str', 'base_id');
    
    
    
    
    public static function findBySlug($slug){
        return SlugCache::firstByAttributes(array('slug' => $slug));
    }
    
    public static function findByBaseStr($str){
        return SlugCache::firstByAttributes(array('base_str' => $str));
    }
    
    public static function findByBaseData($base_str, $base_id){
        return SlugCache::firstByAttributes(array('base_str' => $base_str, 'base_id' => $base_id));
    }

}

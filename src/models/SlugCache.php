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
        return SlugCache::where('slug','=',$slug)->first();
    }
    
    public static function findByBaseStr($str){
        return SlugCache::where('base_str','=',$str)->first();
    }
    
    public static function findByBaseData($base_str, $base_id){
        return SlugCache::where('base_str','=',$base_str)->where('base_id','=',$base_id)->first();
    }
}

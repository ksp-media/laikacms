<?php

namespace KSPM\LCMS\Helper;

use KSPM\LCMS\Model\SlugCache as SlugCache;

class SlugHelper{


    /**
     * @param string $str
     * @param int $base_id
     * @return string
     */
    public static function getSlug($str, $base_id = false){

        if(!$base_id){
            $dbSlug = SlugCache::findByBaseStr($str);
        }else{
            $dbSlug = SlugCache::findByBaseData($str, $base_id);
        }

        if($dbSlug) return $dbSlug->slug;
        
        $slug = strtolower( preg_replace('/[^A-Za-z0-9-]+/', '-', self::_generateSlugFromString($str)));
        
        SlugCache::updateOrCreate(array('slug' => $slug), array('base_str' => $str,'slug' => $slug, 'base_id' => ($base_id) ? $base_id : 0));
        
        return $slug;
    }

    /**
     * @param string $str
     * @return string
     */
    private static function _generateSlugFromString($str){
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'Ae', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'Oe', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'Ue', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'ae', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'oe','ü'=>'ue', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        );

        return strtr($str, $table);
    }
}





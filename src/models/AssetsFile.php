<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class AssetsFile extends Model {
    
    
    const FILETYPE_IMAGE = 1;
    const FILETYPE_VIDEO = 2;
    const FILETYPE_DOCUMENT = 3;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_assets_file';
    protected $primaryKey = 'id';
    protected $guarded = array();
    
    
    public function folder(){
        return $this->hasOne('\KSPM\LCMS\Model\AssetsFolder', 'id', 'folder_id');
    }
    
    
    public static function getFileType($mime){
        $mimePart = explode('/', $mime);
        switch ($mimePart[0]){
            case "image":
                return self::FILETYPE_IMAGE;
            case "video":
                return self::FILETYPE_VIDEO;
            default:
                return self::FILETYPE_DOCUMENT;
                
        }
        
        return self::FILETYPE_DOCUMENT;
    }

    

}

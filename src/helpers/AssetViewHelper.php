<?php

class AssetViewHelper {

    public static function thumb(\KSPM\LCMS\Model\AssetsFile $file){
        
        $dirPath = public_path() . '/' . $file->filepath;
        $destPath = public_path() . '/uploads/assets/thumbs/'.$file->folder_id; 
        if(!file_exists($dirPath . '/' . $file->filename)){
            return false;
        }
        if(!file_exists($destPath.'/'.$file->filename)){
            if (!is_dir($destPath)) {mkdir($destPath);}
             $imagine = new \Imagine\Gd\Imagine();
             $imagine->open($dirPath . '/' . $file->filename)
                    ->thumbnail(new \Imagine\Image\Box(200, 200), \Imagine\Image\ImageInterface::THUMBNAIL_INSET)
                    ->save($destPath . '/' . $file->filename);
        }
        return str_replace('/assets/', '/assets/thumbs/', $file->filepath . '/' . $file->filename);   
    }
    
    
}

<?php
namespace Juboka\Jbkcms\Utilities;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Asset{
    
    const LARGE = "600,500";
    const MEDIUM = "300,250";
    const SMALL = "150,125";


    
    public static function thumb($file, $size = self::MEDIUM){
        
        $dirPath = public_path() . '/' . $file;
        
        $destPath = public_path() . '/uploads/assets/thumbs/'; 
        $filename = explode('/', $file);
        $size = explode(',', $size);
        $filename = $size[0].'_'.$size[1].'_'.$filename[count($filename)-1];
        
        if(!file_exists($dirPath)){
            return $file;
        }
        
        if(!file_exists($destPath.'/'.$filename)){
           
            if (!is_dir($destPath)) {mkdir($destPath);}
             
             $imagine = new \Imagine\Gd\Imagine();
             $imagine->open($dirPath)
                    ->thumbnail(new \Imagine\Image\Box($size[0], $size[1]), \Imagine\Image\ImageInterface::THUMBNAIL_INSET)
                    ->save($destPath . '/' . $filename);
        //     var_dump(/assets/thumbs/$filename); die;
        }
        return '/uploads/assets/thumbs/' . $filename;   
    }
    
}


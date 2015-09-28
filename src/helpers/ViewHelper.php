<?php

class ViewHelper {

    public static function dateToString(\Hub\Model\Item $item) {

        if ($item->date_end === "0000-00-00") {
            return date("d.m.Y", strtotime($item->date_start));
        } else {
            return date("d.m", strtotime($item->date_start)) . ' - ' . date("d.m.Y", strtotime($item->date_end));
        }
    }
    
    public static function formatDate($date, $format = "d.m.Y \u\m H:i ") {
        return date($format, strtotime($date));
    }
    

    public static function unserialize($data) {
        return unserialize($data);
    }

    public static function getSlug($str, $id = false, $combine = false) {
        if($combine && $id){
            $str = $str.'-'.$id;
        }
        return \KSPM\LCMS\Helper\SlugHelper::getSlug($str, $id);
    }

    public static function truncate($text, $chars = 25, $end = "...") {
        if (strlen($text) < $chars) {
            return $text;
        }
        $text = $text . " ";
        $text = substr($text, 0, $chars);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . $end;
        return $text;
    }

}

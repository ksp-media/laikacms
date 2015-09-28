<?php

namespace KSPM\LCMS\Render\Tag;

use KSPM\LCMS\Render\Tag as Tag;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Content extends Tag implements TagInterface{
    
    protected $_pattern = '/@content\(\'(.*?)\'\)(.*?)@endcontent/is';
    
    public function handleResult(){
        foreach ($this->_results as $r) {
            $replace = $r[0];
            $key = $r[1];
            $value = $r[2];

            $o = \KSPM\LCMS\Model\Content::where('key', '=', $key)->first();
            if (!$o) {
                $o = \KSPM\LCMS\Model\Content::create(array('key' => $key, 'value' => $value));
            }
            $this->addTmplObj(array('origin' => $replace, 'value' => $o->value));
        }
    }
    
}

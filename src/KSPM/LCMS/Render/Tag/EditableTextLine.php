<?php

namespace KSPM\LCMS\Render\Tag;

use KSPM\LCMS\Render\Tag as Tag;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class EditableTextLine extends Tag implements TagInterface{
    
    protected $_pattern = '/@editable_text_line\(\'(.*?)\'\)(.*?)@endeditable_text_line/is';
    
    public function handleResult(){
         foreach ($this->_results as $r) {
            if (is_array($this->_contents) && key_exists($r[1], $this->_contents)) {
                $c = $this->_contents[$r[1]];
            } else {
                $c = $r[2];
            }
            $this->addTmplObj(array('origin' => $r[0], 'key' => $r[1], 'value' => $c, 'type' => "input_text"));
        }
    }
    
}

<?php

namespace KSPM\LCMS\Render\Tag;

use KSPM\LCMS\Render\Tag as Tag;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class EditableSelect extends Tag implements TagInterface{
    
    protected $_pattern = '/@editable_select\(\'(.*?)\',\'(.*?)\'\)(.*?)@endeditable_select/is';
    
    public function handleResult(){
         foreach ($this->_results as $r) {
            if (is_array($this->_contents) && key_exists($r[1], $this->_contents)) {
                $c = $this->_contents[$r[1]];
            } else {
                $c = $r[3];
            }
            parse_str($r[2], $params);
            $this->addTmplObj(array('origin' => $r[0], 'key' => $r[1], 'value' => $c, 'type' => "input_select", 'params' => $params));
        }
    }
    
}

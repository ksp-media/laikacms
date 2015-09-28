<?php

namespace KSPM\LCMS\Render\Tag;

use KSPM\LCMS\Render\Tag as Tag;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class IncludeModule extends Tag implements TagInterface{
    
    protected $_pattern = '/@module_include\(\'(.*?)\',\'(.*?)\'\)(.*?)@endmodule_include/is';
    
    public function handleResult(){
         foreach ($this->_results as $r) {
            $action = $r[1];
            parse_str($r[2], $params);
            $replace = $r[0];
            $actionParts = explode('#', $action);
            $class = new $actionParts[0];
            $action = $actionParts[1];
            $this->addTmplObj(array('origin' => $r[0], 
                'value' => '<?php $class = new '.$actionParts[0].'; echo $class->'.$action.'("'.$r[2].'"); ?>'));
        }
    }
    
}

<?php

namespace KSPM\LCMS\Render\Tag;

use KSPM\LCMS\Render\Tag as Tag;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class IncludePage extends Tag implements TagInterface{
    
    protected $_pattern = '/@page_include\(\'(.*?)\'\)/is';
    
    public function handleResult(){
         foreach ($this->_results as $r) {
            $page = $r[1];
            $service = new \KSPM\LCMS\Controllers\PageController();
            $this->addTmplObj(array('origin' => $r[0], 'value' => $service->showAction($page)));
        }
    }
    
}

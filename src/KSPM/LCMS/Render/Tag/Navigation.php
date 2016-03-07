<?php

namespace KSPM\LCMS\Render\Tag;

use KSPM\LCMS\Render\Tag as Tag;
use KSPM\LCMS\Model\Page as Page;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Navigation extends Tag implements TagInterface{
    
    protected $_pattern = '/@navigation\((.*?)\)/is';
    
    public function handleResult(){
        foreach ($this->_results as $r) {
            $page = (int) $r[1];
            if($page > 0){
                $page = Page::find($page);
                $content = "";
                $currentPage = $_SERVER['REQUEST_URI'];
                foreach($page->navChilds() as $p){
                    $active = ($this->hasActiveChild($p, $currentPage))?"active":false;
                    if(!$active){
                        $active = ('/'.$p->slug == $currentPage)?"active":"";
                    }
                    
                    $content .= '<li class="'.$active.'"><a href="/'.$p->slug.'"><span>'.$p->title.'</span></a>';
                    if($p->hasNavChilds()){
                        $content.='<ul class="childs">';
                        foreach($p->navChilds() as $child){
                            $cActive = ('/'.$child->slug == $currentPage)?"active":"";
                            $content .= '<li class="'.$cActive.'"><a href="/'.$child->slug.'"><span>'.$child->title.'</span></a></li>';
                        }
                        $content.='</ul>';
                    }
                    $content .="</li>";
                }
                $this->addTmplObj(array('origin' => $r[0], 'value' => $content));
            } 
        }
    }
    
    public function hasActiveChild($page, $current){
        foreach($page->navChilds() as $child){
            return ('/'.$child->slug == $current)?true:false;
        }
        return false;
    }
    
}

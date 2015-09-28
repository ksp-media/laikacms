<?php
namespace KSPM\LCMS\Render;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Tag{
    
    protected $_pattern;
    protected $_template;
    protected $_contents;
    protected $_results;
    private $_tmplObj = array();
    
    public function __construct($template, $contents) {
        $this->_template = $template;
        $this->_contents = $contents;
    }
    
    /**
     * 
     * @return \KSPM\LCMS\Render\Tag
     */
    public function parse() {
        preg_match_all($this->_pattern, $this->_template, $this->_results, PREG_SET_ORDER);
        $this->handleResult();
        return $this;
    }
    
    protected function addTmplObj($result) {
        $this->_tmplObj[] = $result; 
    }
    
    public function getTmplObj(){
        return $this->_tmplObj;
    }
    
}


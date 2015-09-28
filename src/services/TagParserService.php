<?php

namespace KSPM\LCMS\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TagParserService {

    private $_template;
    private $_contents = array();
    private $_sections = array();
    private $_tmplObj = array();
    private $_renderedTags = "";
    
    private $_tags = array(
        '\KSPM\LCMS\Render\Tag\EditableText',
        '\KSPM\LCMS\Render\Tag\EditableTextLine',
        '\KSPM\LCMS\Render\Tag\EditableSelect',
        '\KSPM\LCMS\Render\Tag\IncludeModule',
        '\KSPM\LCMS\Render\Tag\EditableAsset',
        '\KSPM\LCMS\Render\Tag\Content',
        '\KSPM\LCMS\Render\Tag\IncludePage',
    );

    public function __construct($template, $contents) {
        $this->_template = $template;
        $this->_renderedTags = $template;
        $this->_contents = unserialize($contents);
		$this->_parseTemplateFileTag();
		$this->_parseUseTemplateTag();
        //$this->_mergeSections();
        $this->_registerTags();
    }
    
    private function _registerTags(){
        foreach($this->_tags as $tagClass){
            //var_dump($tagClass);
            $class= $tagClass;
            $tag = new $class($this->_template, $this->_contents);
            $this->_tmplObj = array_merge($tag->parse()->getTmplObj(), $this->_tmplObj);
            
        }
    }
    
    public function registerTag($tag){
        $this->_tags[] = $tag;
    }

    public static function compile($template, $contents) {
        $service = new TagParserService($template, $contents);
        return $service->render();
    }

    public function render() {
        $this->_renderTags();
        return $this->_renderedTags;
    }

    public function getResult() {
        return $this->_tmplObj;
    }

    private function _parseTemplateFileTag() {
        $this->_findSections('final');
        $pattern = '/@template_file\(\'(.*?)\'\)/is';
        preg_match_all($pattern, $this->_template, $result, PREG_SET_ORDER);
        if (count($result) > 0) {
            foreach ($result as $r) {
                $this->_template = file_get_contents(app_path() . '/../' . $r[1]);
				return;
            }
        }
        $this->_findSections('before');
        $this->_mergeSections();
        $this->_renderedTags = $this->_template;
    }

    private function _parseUseTemplateTag() {
        $this->_findSections('final');
        $pattern = '/@use\(\'(.*?)\'\)/is';
        preg_match_all($pattern, $this->_template, $result, PREG_SET_ORDER);
        if (count($result) > 0) {
            foreach ($result as $r) {
                $this->_template = \KSPM\LCMS\Model\Page::where('slug', '=', $r[1])->first()->template;
                break;
            }
        }
        $this->_findSections('before');
        $this->_mergeSections();
        $this->_renderedTags = $this->_template;
    }


    private function _findSections($state) {
        $pattern = '/@section\(\'(.*?)\'\)(.*?)@endsection/is';
        preg_match_all($pattern, $this->_template, $result, PREG_SET_ORDER);
        foreach ($result as $r) {
            $data['tag'] = $r[0];
            $data['key'] = $r[1];
            $data['value'] = $r[2];
            $this->_sections[$state][] = $data;
        }
    }

    private function _mergeSections() {
        if (!array_key_exists('before', $this->_sections)) {
            return;
        }
        foreach ($this->_sections['before'] as $s) {
            $found = false;
            if (array_key_exists('final', $this->_sections)) {
                foreach ($this->_sections['final'] as $f) {
                    if ($f['key'] == $s['key']) {
                        $this->_template = str_replace($s['tag'], $f['value'], $this->_template);
                        $found = true;
                    }
                }
            }
            if ($found == false) {
                $this->_template = str_replace($s['tag'], $s['value'], $this->_template);
            }
        }
    }

    private function _renderTags() {
        foreach ($this->_tmplObj as $obj) {
            $this->_renderedTags = str_replace($obj['origin'], $obj['value'], $this->_renderedTags);
        }
    }

}

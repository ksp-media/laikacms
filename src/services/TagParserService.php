<?php

namespace KSPM\LCMS\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TagParserService {

    static private $instance = null;
    private $_template;
    private $_originTemplate;
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

    public function __construct() {
        
    }

    /**
     * 
     * @return KSPM\LCMS\Service\TagParserService
     */
    static public function instance() {
        if (null === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function _registerTags() {
        foreach ($this->_tags as $tagClass) {
            $class = $tagClass;
            $tag = new $class($this->_template, $this->_contents);
            $this->_tmplObj = array_merge($tag->parse()->getTmplObj(), $this->_tmplObj);
        }
    }

    public function registerTag($tag) {
        $this->_tags[] = $tag;
    }

    public function compile($template, $contents) {
        $this->_template = $template;
        $this->_originTemplate = $template;
        $this->_renderedTags = $template;
        $this->_contents = unserialize($contents);
        $this->_parseTemplateFileTag();
        $this->_parseUseTemplateTag();
        //$this->_mergeSections();
        $this->_registerTags();
        return $this->render();
    }

    public function render() {
        $this->_renderTags();
        //$this->_cleanupResponse();
        return $this->_renderedTags;
    }

    public function getResult($template, $contents) {
        $this->_template = $template;
        $this->_contents = $contents;
        $this->_registerTags();
        return $this->_tmplObj;
    }

    public function getBlocks($template, $contents) {
        $this->_template = $template;
        $this->_originTemplate = $template;
        $this->_renderedTags = $template;
        $this->_contents = unserialize($contents);
        $this->_registerTags();
        $blocks = $this->_getBlockInfo($this->_template);
        if (count($blocks) === 0) {
            $final = ['main' => $this->_tmplObj];
            return $final;
        }
        $final = [];
        $final = ['main' => $this->_tmplObj];
        foreach ($blocks as $block) {
            $final[$block['key']] = [];
            foreach ($this->_tags as $tagClass) {
                $class = $tagClass;
                $tag = new $class($block['value'], $this->_contents);
                $result = $tag->parse()->getTmplObj();
                if (count($result) > 0) {
                    $final[$block['key']] = array_merge($final[$block['key']], $result);
                }
            }
        }
        $final['main'] = $this->_removeDuplicatedKeysFromMain($final);
        return $final;
    }

    private function _removeDuplicatedKeysFromMain($final) {
        foreach ($final as $key => $block) {
            if ($key === 'main')
                continue;
            foreach ($block as $item) {
                $i = 0;
                foreach ($final['main'] as $mainItem) {
                    if (key_exists('key', $mainItem) && key_exists('key', $item)){
                        if(($mainItem['key'] == $item['key'])){
                            unset($final['main'][$this->_getIndexForKey($mainItem['key'], $final['main'])]);
                        }
                    }
                    $i++;
                }
                $final['main'] = array_values($final['main']);
            }
        }
        return array_values($final['main']);
    }

    private function _getIndexForKey($key, $main) {
        $i = 0;
        foreach ($main as $item) {
            if (key_exists('key', $item) && ($item['key'] == $key)) {
                return $i;
            }
            $i++;
        }
    }

    private function _getBlockInfo($content) {
        $final = [];
        $pattern = '/@block\(\'(.*?)\'\)(.*?)@endblock/is';
        preg_match_all($pattern, $content, $result, PREG_SET_ORDER);
        foreach ($result as $r) {
            $data['tag'] = $r[0];
            $data['key'] = $r[1];
            $data['value'] = $r[2];
            $final[] = $data;
        }
        return $final;
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

    private function _cleanupResponse() {
        $callback = function ($match) {
            return '';
        };

        $this->_renderedTags = preg_replace('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', '', $this->_renderedTags);
    }
    
    public function reset(){
        $this->_template = false;
        $this->_originTemplate = false;
        $this->_contents = array();
        $this->_sections = array();
        $this->_tmplObj = array();
        $this->_renderedTags = "";
    }

}

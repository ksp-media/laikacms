<?php

namespace KSPM\LCMS\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModuleService {

    protected static $instance = null;
    private $_moduleList;

    /**
     * 
     * @return KSPM\LCMS\Service\ModuleService
     */
    public static function getInstance() {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function getBackendModules() {
        if (!$this->_moduleList) {
            $this->_setModuleList();
        }
        $data = [];
        foreach ($this->_moduleList as $module) {
            if (key_exists('backend', $module)) {
                $data[] = $module['backend'];
            }
        }
        return $data;
    }

    private function _setModuleList() {
        if (\Cache::has('modules.backend.list')) {
            $this->_moduleList = \Cache::get('modules.backend.list');
            $this->_addViewNamespaces();
            return;
        }

        $moduleDir = app_path() . '/../modules/';
        $result = array();
        if ($handle = opendir($moduleDir)) {
            while (false !== ($dir = readdir($handle))) {
                if ($dir != '.' && $dir != '..') {
                    if (is_dir($moduleDir . $dir)) {
                        $backendData = false;
                        if (file_exists($moduleDir . $dir . '/backend.json')) {
                            $backendData = json_decode(file_get_contents($moduleDir . $dir . '/backend.json'));
                        }
                        $result[] = ['name' => $dir, "dir" => $moduleDir . $dir, 'backend' => $backendData];
                    }
                }
            }
            closedir($handle);
        }

        $this->_moduleList = $result;
        \Cache::forever('modules.backend.list', $result);
        $this->_addViewNamespaces();

    }

    private function _addViewNamespaces() {
        foreach ($this->_moduleList as $module) {
            \View::addNamespace(lcfirst($module['name']), $module['dir'] . '/views');
        }
    }

}

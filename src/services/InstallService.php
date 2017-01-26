<?php

namespace KSPM\LCMS\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InstallService {

    protected static $instance = null;

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

    public static function isInstalled() {
        return (\Schema::hasTable('laikacms_user'));
    }

    public static function install() {
        echo 'install database <br />';
        var_dump(self::runSqlFile(__DIR__ . '/../install/database.sql'));
        echo 'database succesfully installed <br /> ... refresh your browser!';
    }

     private static function runSqlFile($location) {
        //load file
        $commands = file_get_contents($location);
        //delete comments
        $lines = explode("\n", $commands);
        $commands = '';
 
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line) {
                $commands .= $line . "\n";
            }
        }
        //convert to array
        $commands = explode(";", $commands);
        //run commands
        $total = $success = 0;
        foreach ($commands as $command) {
            if (trim($command)) {
                $success += (\DB::statement($command) == false ? 0 : 1);
                $total += 1;
            }
        }

        //return number of successful queries and total number of queries found
        return array(
            "success" => $success,
            "total" => $total
        );
    }

}

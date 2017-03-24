<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 16:25
 */

namespace sinri\musikago\core;


class LibConfig extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    public function shortName()
    {
        return "config";
    }

    public function readConfig($config_cluster,$item=null,$key=null){
        if(!preg_match('/^[A-Za-z0-9_]+$/',$config_cluster)){
            throw new \Exception("Illegal Config Cluster Name {$config_cluster}!");
        }
        $config_file= __DIR__ . '/../config/' .$config_cluster.'.php';
        if(!file_exists($config_file)){
            throw new \Exception("No such config file!");
        }
        $config=[];
        require $config_file;

        if($item!==null){
            if(!isset($config[$item])){
                return null;
            }
            if($key!==null){
                if(!isset($config[$item][$key])){
                    return null;
                }
                return $config[$item][$key];
            }
            return $config[$item];
        }

        return $config;
    }
}
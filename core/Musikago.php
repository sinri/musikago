<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 10:27
 */

namespace sinri\musikago\core;

use sinri\SinriDatabaseAgent\SinriPDO;

class Musikago
{
    private static $instance=null;
    private $components=[];

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance=new Musikago();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        $this->components=[];
    }

    public function start()
    {
        $this->loadDefaultComponents();
        try {
            // Seek agent and pass request to it
            $input_error = LibInput::REQUEST_NO_ERROR;
            $agent_name = $this->input->readGet('agent', 'HomeAgent', '/^[A-Za-z0-9_\/]+$/', $input_error);
            if ($input_error === LibInput::REQUEST_REGEX_NOT_MATCH) {
                // 404 Warning
                throw new \Exception("Agent {$agent_name} is not correctly declared.");
            }
            $agent = $this->loadAgent($agent_name);

            $action_name = $this->input->readGet('action', 'index', '/^[A-Za-z0-9_]+$/', $input_error);
            if ($input_error === LibInput::REQUEST_REGEX_NOT_MATCH || !method_exists($agent, $action_name)) {
                // action_name not found
                throw new \Exception("Action {$action_name} is not correctly declared.");
            }

        } catch (\Exception $exception) {
            $this->output->error("The request could not be correctly handled!", $exception);
            return;
        }

        // The exception from process inside the agent would not be handled globally
        $agent->$action_name();
    }

    public function runUnderCLI($action_name,$method_name='defaultMethod',$params=[]){
        $this->loadDefaultComponents();
        $action = $this->loadAction($action_name);
        if(method_exists($action,$method_name)) {
            $action->$method_name($params);
        }else{
            throw new \Exception("No such method in the Action!");
        }
    }

    public function loadDefaultComponents(){
        // Load helpers and libraries
        $this->loadHelper("CommonHelper");

        $this->loadCoreLibrary("LibConfig");
        $this->loadCoreLibrary("LibInput");
        $this->loadCoreLibrary("LibOutput");
        $this->loadCoreLibrary("LibSession");

        // $this->loadCoreLibrary("LibDatabase");
        $this->loadDatabase();
    }

    public function loadHelper($name){
        $this->loadComponentFile('helper',$name);
    }
    public function loadCoreLibrary($name){
        $this->loadComponentFile('core',"BaseLibrary");
        $this->loadComponentFile('core',$name);
        $long_class_name="sinri\\musikago\\core\\$name";
        $lib=new $long_class_name();
        $lib_key=$name;
        if($lib->shortName()){
            $lib_key=$lib->shortName();
        }
        $this->components[$lib_key]=$lib;
    }
    public function loadLibrary($name){
        $this->loadComponentFile('core',"BaseLibrary");
        $this->loadComponentFile('library',$name);
        $long_class_name="sinri\\musikago\\library\\$name";
        $lib=new $long_class_name();
        $lib_key=$name;
        if($lib->shortName()){
            $lib_key=$lib->shortName();
        }
        $this->components[$lib_key]=$lib;
    }
    public function loadAgent($name)
    {
        $this->loadComponentFile('agent',"BaseAgent");
        $this->loadComponentFile('agent', $name);
        $long_class_name = "sinri\\musikago\\agent\\$name";
        $agent = new $long_class_name();
        return $agent;
    }
    public function loadAction($name)
    {
        $this->loadComponentFile('action',"BaseAction");
        $this->loadComponentFile('action', $name);
        $long_class_name = "sinri\\musikago\\action\\$name";
        $action = new $long_class_name();
        return $action;
    }
    private function loadComponentFile($aspect,$name){
        $filename=__DIR__.'/../'.$aspect.'/'.$name.'.php';
        if(file_exists($filename)){
            require_once $filename;
        }else{
            throw new \Exception("The {$aspect} called '{$name}' could not be found.");
        }
    }

    private function loadDatabase(){
        $target=$this->config->readConfig('DatabaseConfig','target');
        $params=$this->config->readConfig('DatabaseConfig','source',$target);
        if(!($target && $params && is_array($params))){
            throw new \Exception("Database Config Error");
        }
        $this->components['db']=new SinriPDO($params);
    }

    public function __get($name)
    {
        if(isset($this->components[$name])){
            return $this->components[$name];
        }else{
            return null;
        }
    }
}
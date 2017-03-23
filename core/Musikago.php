<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 10:27
 */

namespace sinri\musikago\core;


use sinri\musikago\library\LibInput;

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

    public function start(){
        try {
            $this->components = [];
            // Load helpers and libraries
            $this->loadHelper("CommonHelper");

            $this->loadLibrary("LibInput");
            $this->loadLibrary("LibOutput");

            // Seek agent and pass request to it
            $input_error = LibInput::REQUEST_NO_ERROR;
            $agent_name = $this->LibInput->readGet('agent', 'HomeAgent', '/^[A-Za-z0-9_\/]+$/', $input_error);
            if ($input_error === LibInput::REQUEST_REGEX_NOT_MATCH) {
                // 404 Warning
                throw new \Exception("Agent {$agent_name} is not correctly declared.");
            }
            $agent = $this->loadAgent($agent_name);

            $action_name = $this->LibInput->readGet('action', 'index', '/^[A-Za-z0-9_]+$/', $input_error);
            if ($input_error===LibInput::REQUEST_REGEX_NOT_MATCH || !method_exists($agent, $action_name)) {
                // action_name not found
                throw new \Exception("Action {$action_name} is not correctly declared.");
            }
            $params = $this->LibInput->fullPostFields();
        }catch(\Exception $exception){
            $this->LibOutput->error("The request could not be correctly handled!",$exception);
            return;
        }

        // The exception from process inside the agent would not be handled globally
        $agent->$action_name($params);
    }

    public function loadHelper($name){
        $this->loadComponentFile('helper',$name);
    }
    public function loadLibrary($name){
        $this->loadComponentFile('library',"BaseLibrary");
        $this->loadComponentFile('library',$name);
        $long_class_name="sinri\\musikago\\library\\$name";
        $lib=new $long_class_name();
        $this->components[$name]=$lib;
    }
    public function loadAgent($name)
    {
        $this->loadComponentFile('agent',"BaseAgent");
        $this->loadComponentFile('agent', $name);
        $long_class_name = "sinri\\musikago\\agent\\$name";
        $agent = new $long_class_name();
        return $agent;
    }
    public function loadView($name){
        $this->loadComponentFile('view', $name);
    }
    private function loadComponentFile($aspect,$name){
        $filename=__DIR__.'/../'.$aspect.'/'.$name.'.php';
        if(file_exists($filename)){
            require_once $filename;
        }else{
            throw new \Exception("The {$aspect} called '{$name}' could not be found.");
        }
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
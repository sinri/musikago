<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 16:35
 */

namespace sinri\musikago\core;


use sinri\SinriDatabaseAgent\SinriPDO;
/*
class LibDatabase extends SinriPDO{
    private $Musikago;
    public function __construct(array $params=[])
    {
        $this->Musikago=Musikago();
        if(empty($params)){
            $target=$this->Musikago->config->readConfig('DatabaseConfig','target');
            $params=$this->Musikago->config->readConfig('DatabaseConfig','source',$target);

            if(!($target && $params && is_array($params))){
                throw new \Exception("Database Config Error");
            }
        }
        parent::__construct($params);
    }
}
*/

/**
 * Class LibDatabase
 * @deprecated
 * @package sinri\musikago\core
 */
class LibDatabase extends BaseLibrary
{
    private $db;

    public function __construct()
    {
        parent::__construct();

        $target=$this->Musikago->config->readConfig('DatabaseConfig','target');
        $params=$this->Musikago->config->readConfig('DatabaseConfig','source',$target);
//        echo $target;die();
//        print_r($params);die();
        if(!($target && $params && is_array($params))){
            throw new \Exception("Database Config Error");
        }

        $this->db=new SinriPDO($params);
    }

    public function shortName()
    {
        return "db";
    }

    public function __call($name, $arguments)
    {
        if(method_exists($this->db,$name)){
           return call_user_func_array(array(&$this->db,$name),$arguments);
        }
        throw new \Exception("Cannot found database agent method!");
    }
}

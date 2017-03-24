<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:04
 */

namespace sinri\musikago\agent;


class HomeAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $_SESSION['x']=$_SESSION['x']?($_SESSION['x']+1):1;
        $assigned_data=[
            'admin_info'=>$_SESSION['x']
        ];
        $this->Musikago->output->view("HomeAgent/IndexView",$assigned_data);
    }
    public function test(){
        $admin_info=$this->Musikago->db->getRow("SELECT * FROM `user` WHERE user_name='admin'");
        $assigned_data=[
            'admin_info'=>$admin_info
        ];
        $this->Musikago->output->view("HomeAgent/IndexView",$assigned_data);
    }
}
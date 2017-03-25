<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 23:20
 */

namespace sinri\musikago\agent;


use sinri\musikago\core\LibOutput;

class UserAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
        $this->Musikago->loadLibrary('UserKit');
    }

    public function index(){
        $this->Musikago->output->view('UserAgent/IndexView');
    }

    public function userProfile(){
        $this->Musikago->output->view('UserAgent/UserProfileView');
    }

    public function ajaxUserInfo(){
        $user_id=$this->Musikago->input->readGet('user_id','0');
        $user_info=$this->Musikago->UserKit->getUserInfo($user_id);
        $data=[
            "user_info"=>$user_info,
        ];
        $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_OK,$data);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 23:33
 */

namespace sinri\musikago\agent;


use sinri\musikago\core\LibInput;
use sinri\musikago\core\LibOutput;

class SessionAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
        $this->Musikago->loadLibrary('UserKit');
    }

    public function needLogin(){
        return false;
    }

    public function index()
    {
        $this->entrance();
    }

    public function login()
    {
        $this->Musikago->session->sessionRestart();

        $input_error = LibInput::REQUEST_NO_ERROR;
        $username = $this->Musikago->input->readPost('username', null, '/^[A-Za-z0-9_\/]+$/', $input_error);
        $password = $this->Musikago->input->readPost('password', null, null, $input_error);

        if (!$username || !$password) {
            $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_FAIL, "User Auth Info Illegal.");
            return;
        }
        $user_info = $this->Musikago->UserKit->checkUserPassword($username, $password);
        if (empty($user_info)) {
            $error_message="User Auth Failed.";

            //$real_hash=$this->Musikago->UserKit->encodePassword($password);
            //$error_message.=" [DEBUG] error hash: ".$real_hash;

            $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_FAIL, $error_message);
            return;
        }

        $_SESSION['user_id'] = $user_info['user_id'];
        $_SESSION['user_info'] = $user_info;

        $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_OK, []);
        return;
    }

    public function currentUserInfo()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_FAIL,"Not Login");
            return;
        }
        $user_id = $_SESSION['user_id'];
        $user_info=$this->Musikago->UserKit->getUserInfo($user_id);
        if(empty($user_info)){
            $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_FAIL,"No Such User");
            return;
        }
        $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_OK,$user_info);
        return;
    }
}
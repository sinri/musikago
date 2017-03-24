<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 22:51
 */

namespace sinri\musikago\library;


use sinri\musikago\core\BaseLibrary;

class UserKit extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listUsers($conditions=[]){
        $sql="SELECT u.user_id,u.user_name,u.display_name,u.email,u.create_time,u.update_time 
            FROM `user` u
            WHERE 1
        ";
        foreach ($conditions as $key => $value){
            $value=$this->Musikago->db->quote($value);
            $sql.=" and `{$key}` = {$value} ";
        }
        $list=$this->db->getAll($sql);
        return $list;
    }

    public function checkUserPassword($username,$password){
        $username=$this->db->quote($username);
        // $password=$this->db->quote($password);
        $sql="SELECT u.user_id,u.user_name,u.display_name,u.email,u.create_time,u.update_time,u.password
        FROM `user` u WHERE u.user_name={$username} ";
        $row=$this->db->getRow($sql);
        if($row && password_verify($password,$row['password'])){
            return $row;
        }
        return false;
    }

    public function encodePassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUserInfo($user_id){
        $user_id=intval($user_id);
        $sql="SELECT u.user_id,u.user_name,u.display_name,u.email,u.create_time,u.update_time 
            FROM `user` u
            WHERE u.user_id='{$user_id}'
        ";
        $info=$this->db->getRow($sql);
        return $info;
    }
}

/*
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) NOT NULL DEFAULT '',
  `display_name` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(512) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */
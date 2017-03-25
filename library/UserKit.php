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

    public function listUsers($conditions = [])
    {
        $sql = "SELECT 
          u.user_id,u.user_name,u.display_name,u.email,
          u.create_time,u.update_time, 
          u.site_role
        FROM `user` u
        WHERE u.disabled!='YES'
        ";
        foreach ($conditions as $key => $value) {
            $value = $this->Musikago->db->quote($value);
            $sql .= " and `{$key}` = {$value} ";
        }
        $list = $this->db->getAll($sql);
        return $list;
    }

    public function checkUserPassword($username, $password)
    {
        $username = $this->db->quote($username);
        // $password=$this->db->quote($password);
        $sql = "SELECT u.user_id,u.user_name,u.display_name,u.email,u.create_time,u.update_time,u.password, u.site_role
        FROM `user` u WHERE u.user_name={$username} and u.disabled!='YES'";
        $row = $this->db->getRow($sql);
        if ($row && password_verify($password, $row['password'])) {
            return $row;
        }
        return false;
    }

    public function encodePassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUserInfo($user_id)
    {
        $user_id = intval($user_id);
        $sql = "SELECT u.user_id,u.user_name,u.display_name,u.email,u.create_time,u.update_time, u.site_role
            FROM `user` u
            WHERE u.user_id='{$user_id}' 
        ";
        $info = $this->db->getRow($sql);
        return $info;
    }
}

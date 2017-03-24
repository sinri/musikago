<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 14:01
 */

$config['target']='default';
$config['source']=[
    'default'=>[
        "host" => '127.0.0.1',
        "port" => '3306',
        "username" => 'root',
        "password" => '123456',
        "database" => 'musikago',
        "charset" => 'utf8',
    ],
];

//namespace sinri\musikago\config;
//
//
//class DatabaseConfig
//{
//
//    public static function configForDatabase($database_name='default'){
//        $config_set=[
//            'default'=>[
//                "host"=>'localhost',
//                "port"=>'3306',
//                "username"=>'root',
//                "password"=>'123456',
//                "database"=>'musikago',
//                "charset"=>'utf8',
//            ]
//        ];
//        return isset($config_set[$database_name])?$config_set[$database_name]:false;
//    }
//}
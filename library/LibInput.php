<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 10:35
 */

namespace sinri\musikago\library;


class LibInput extends BaseLibrary
{
    const REQUEST_NO_ERROR = 0;
    const REQUEST_FIELD_NOT_FOUND = 1;
    const REQUEST_REGEX_NOT_MATCH = 2;


    public function __construct()
    {
        parent::__construct();
    }

    public function getRequest($name, $default = null, $regex = null, &$error = 0)
    {
        if (!isset($_REQUEST[$name])) {
            $error = self::REQUEST_FIELD_NOT_FOUND;
            return $default;
        }
        $value = $_REQUEST[$name];
        if ($regex === null) return $value;
        if (!preg_match($regex, $value)) {
            $error = self::REQUEST_REGEX_NOT_MATCH;
            return $default;
        }
        return $value;
    }

    public function readGet($name, $default = null, $regex = null, &$error = 0)
    {
        if (!isset($_GET[$name])) {
            $error = self::REQUEST_FIELD_NOT_FOUND;
            return $default;
        }
        $value = $_GET[$name];
        if ($regex === null) return $value;
        if (!preg_match($regex, $value)) {
            $error = self::REQUEST_REGEX_NOT_MATCH;
            return $default;
        }
        return $value;
    }

    public function readPost($name, $default = null, $regex = null, &$error = 0)
    {
        if (!isset($_POST[$name])) {
            $error = self::REQUEST_FIELD_NOT_FOUND;
            return $default;
        }
        $value = $_POST[$name];
        if ($regex === null) return $value;
        if (!preg_match($regex, $value)) {
            $error = self::REQUEST_REGEX_NOT_MATCH;
            return $default;
        }
        return $value;
    }

    public function fullPostFields(){
        return $_POST?$_POST:[];
    }

    /**
     * 是否是AJAx提交的
     */
    public function isAjax()
    {
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否是GET提交的
     */
    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
    }

    /**
     * 是否是POST提交
     */
    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
    }

    public function isCLI()
    {
        return (php_sapi_name() === 'cli') ? true : false;
    }
}
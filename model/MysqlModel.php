<?php

/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/1/19
 * Time: 13:07
 */
class MysqlModel
{
//数据库连接
    function database(){
        //连接数据库
        $configArr = array(
            'host' => 'localhost',
            'port' => '3306',
            'user' => 'root',
            'passwd' => '',
            'dbname' => 'login',
        );
        return $mysql = new \PdoModel($configArr);
    }
}
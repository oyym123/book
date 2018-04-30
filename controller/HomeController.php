<?php
namespace App\controller;
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/4/14
 * Time: 10:40
 */

class HomeController
{
    public function index()
    {
        $userId = \UserModel::isLogin();
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $article = $mysql->where(['status' => 1])->select('article');
        $param = [
            'favorite' => $article,
            'recently' => $recode = $mysql->where(['user_id' => "{$userId}"])->order(['created_at' => 'desc'])->all('reading_record')
        ];
        \FuncController::render('index', ['param' => json_encode($param)]);
    }
}
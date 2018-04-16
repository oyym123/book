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
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $article = $mysql->select('article');
        $chapter = $mysql->where(['article_id' => $article[0]['id']])->select('chapter');
        $param = [
            'favorite' => $article
        ];
        \FuncController::render('index', $param);
    }
}
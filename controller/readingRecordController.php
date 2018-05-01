<?php
namespace App\controller;
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/4/14
 * Time: 10:40
 */

class ReadingRecordController
{
    /** 上次浏览 */
    public function lastViewed()
    {
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $userId = \UserModel::isLogin();
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id) {
            $recode = $mysql->where(['id' => "{$id}"])->one('reading_record');
        } else {
            $recode = $mysql->where(['user_id' => "{$userId}"])->order(['created_at' => 'desc'])->one('reading_record');
        }

        if (!empty($recode)) {
            $limit = round($recode['chapter_id'] / 5);
            $chapter = $mysql->where(['article_id' => $recode['article_id']])->order('chapter_id')->limit($limit + 1, 5)->select('chapter');
        } else {
            $limit = 0;
            $chapter = [];
            $recode['title'] = '';
        }
        \FuncController::render('article/index', ['limit' => $limit, 'chapter' => json_encode($chapter), 'title' => $recode['title']]);
    }

    /** 最近浏览 */
    public function recentlyViewed()
    {
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $userId = \UserModel::isLogin();
        $recode = $mysql->where(['user_id' => "{$userId}"])->order('article_id')->order(['created_at' => 'desc'])->all('reading_record');
        return $recode;
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/1/19
 * Time: 0:43
 */
class UserModel
{
    /** 检验是否登入 */
    public static function isLogin()
    {
        session_start();
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $session = isset($_SESSION['token']) ? $_SESSION['token'] : '';
        $user = $mysql->where(['token' => "'{$session}'"])->field('id')->one('user');
        if (!empty($user)) {
            return $user['id'];
        } else {
            header("Location: index.php?c=user&a=register");
        }
    }

    /** 创建新用户 */
    public function create($param)
    {
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $time = [
            'created_at' => time(),
            'updated_at' => time(),
            'password' => md5(md5($param['password']))
        ];
        return $mysql->insert('user', array_merge($param, $time));
    }

    /** 检验是否是唯一的用户 */
    public function check($param)
    {
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        return $mysql->where(['phone_number' => $param['phone_number']])->select('user');
    }

    /** 登入操作 */
    public function login($param)
    {
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        //这一步开启redis缓存
        /* $redis = \RedisModel::connect();
             if ($x = json_decode($redis->get('user' . $param['phone_number']), true)) {
                 if ($x['password'] == md5(md5($param['password']))) {
                     return true;
                 }
             }*/

        $query = $mysql->where(['phone_number' => $param['phone_number']])->select('user');
        if (!empty($query) && $query[0]['password'] == md5(md5($param['password']))) {
            //设置redis缓存
            //   $this->setCache($query[0]);
            return true;
        }
        return false;
    }

    /** 设置redis缓存 */
    public function setCache($param)
    {
        $redis = \RedisModel::connect();
        $redis->setex('user' . $param['phone_number'], 600, json_encode($param));//数据缓10分钟
    }

    /** 设置验证规则 */
    public function rule($scene)
    {
        foreach ($this->translate() as $key => $value) {
            switch ($scene) { //设置验证场景
                case 'login':
                    if ($key == 'phone_number' || $key == 'password') {
                        if (!isset($_POST[$key]{0})) {
                            return $value . '不能为空';
                        }
                        if (!$this->login($_POST)) {
                            return $value . '账号或密码错误！';
                        }
                    }
                    break;
                case 'register':
                    if (!isset($_POST[$key]{0})) {
                        return $value . '不能为空';
                    };
                    if ($this->check($_POST)) {
                        return '该手机号已注册过，请重新注册！';
                    }
                    break;
            }
        }

        if (isset($_POST['password']{16})) {
            return '密码长度不能超过16个字符！';
        } elseif (!isset($_POST['password']{5})) {
            return '密码长度不能少于6个字符！';
        } elseif (isset($_POST['repassword']) && $_POST['repassword'] !== $_POST['password']) {
            return '确认密码与密码不一致，请重新填写';
        } elseif (!\helperModel::isMobile($_POST['phone_number'])) {
            return '手机号填写不正确';
        } else {
            return true;
        }
    }

    /** 字段对应的中文 */
    public function translate()
    {
        return [
            'sex' => '性别',
            'phone_number' => '手机号',
            'password' => '密码',
            'repassword' => '确认密码',
        ];
    }

}
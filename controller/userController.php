<?php
namespace App\controller;

/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/1/18
 * Time: 17:34
 */

class userController
{
    /** 注册页 */
    public function register()
    {
        // \HelperModel::writeLog($_POST);
        if (!isset($_POST['phone_number'])) {
            header("Location: /login/view/user/register.php");
        }
        $userModel = new \UserModel();
        if ($userModel->rule('register') === true) {
            //新增用户成功的sql语句会返回 1
            if (!$userModel->create($_POST)) {
                echo '注册失败，请重新注册！';
            }
            echo 1;
        } else {
            echo $userModel->rule('register');
        }
    }

    /** 登入页 */
    public function login()
    {

        if (!isset($_POST['phone_number'])) {
            header("Location: /login/view/user/register.php");
        }
        $userModel = new \UserModel();
        if ($userModel->rule('login') === true) {
            echo 1;
        } else {
            echo $userModel->rule('login');
        }
    }
}
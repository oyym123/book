<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/1/18
 * Time: 18:30
 */
class HelperModel
{
    /** 判断是否是手机 */
    public static function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /** 写入测试数据 */
    public static function writeLog($data)
    {
        file_put_contents('./test.log', date('Y-m-d-H:i:s') . var_export($data, 1) . "\n", FILE_APPEND);
    }
}
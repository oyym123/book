<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/1/19
 * Time: 0:33
 */

class RedisModel{
    public static function connect(){
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        return $redis;
    }
}


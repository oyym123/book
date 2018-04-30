<?php

/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/4/14
 * Time: 11:52
 */
class FuncController
{
    /** 跳转视图 */
    public static function render($address = null, $param = [])
    {
        $back = debug_backtrace()[1]['class'];
        preg_match("/controller\\\\(.*?)Controller/", $back, $class);
        $address = $address ?: $back[1];

        if (strpos($address, '/') === false) {
            $url = "/view/" . strtolower($class[1]) . "/" . $address . ".php";
        } else {
            $address = explode('/', $address);
            $url = "/view/" . $address[0] . "/" . $address[1] . ".php";
        }
        $str = '';
        foreach ($param as $key => $item) {
            $str .= ' <input type="hidden" name="' . $key . '" value=' . base64_encode($item) . ' /> ';
        }
        // var_dump(json_encode($param));exit;
        echo '<form name="form" method="post" action="' . $url . '">
                  ' . $str . '
              </form>       
            <script type="text/javascript">
                window.onload=(function(){document.form.submit();});
            </script>';
    }
}
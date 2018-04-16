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
        $back = debug_backtrace()[1]['args'][0];
        $address = $address ?: $back[1];
        $url = "/view/" . $back[0] . "/" . $address . ".php";
        //var_dump(json_encode($param));exit;
        echo '<form name="form" method="post" action="' . $url . '">
                  <input type="hidden" name="param"  size="50000000" value=' . json_encode($param) . ' />
              </form>       
            <script type="text/javascript">
                window.onload=(function(){document.form.submit();});
            </script>';
    }

    public function chrtonum($str)
    {
        $num = 0;
        $bins = array("零", "一", "二", "三", "四", "五", "六", "七", "八", "九", 'a' => "个", 'b' => "十", 'c' => "百", 'd' => "千", 'e' => "万");
        $bits = array('a' => 1, 'b' => 10, 'c' => 100, 'd' => 1000, 'e' => 10000);
        foreach ($bins as $key => $val) {
            if (strpos(" " . $str, $val)) $str = str_replace($val, $key, $str);
        }
        foreach (str_split($str, 2) as $val) {
            $temp = str_split($val, 1);
            if (count($temp) == 1) $temp[1] = "a";
            if (isset($bits[$temp[0]])) {
                $num = $bits[$temp[0]] + (int)$temp[1];
            } else {
                $num += (int)$temp[0] * $bits[$temp[1]];
            }
        }
        var_dump($num);exit;
        return $num;
    }
}
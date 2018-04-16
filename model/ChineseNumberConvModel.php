<?php

/**把中文数字转换成阿拉伯数字
 */
class ChineseNumberConvModel
{

    private $chinesnumber = array(
        "零",
        "一",
        "二",
        "三",
        "四",
        "五",
        "六",
        "七",
        "八",
        "九"
    );

    private $arabicnumber = array(
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9"
    );

    function toAlpha($cString)
    {
        preg_match("/^十(.*)/", $cString, $match);
        if ($match != null) {
            $cString = "一" . $cString;
        }

        //	preg_match("/(.*?)亿(.*)/", $cString,$match);
        $number = $this->parse($cString);
        //echo "结果:".$number;
        return $number;

    }

    function fromAlpha($aString)
    {
        $capnum = $this->chinesnumber;
        $capdigit = array("", "十", "百", "千");
        $subdata = explode(".", $aString);
        $yuan = $subdata[0];
        $j = 0;
        $nonzero = 0;
        $cncap = "";
        for ($i = 0; $i < strlen($subdata[0]); $i++) {
            if (4 == $i) {
                $j = 0;
                $nonzero = 0;
                $cncap = "万" . $cncap;
            }
            if (8 == $i) {
                $j = 0;
                $nonzero = 0;
                $cncap = "亿" . $cncap;
            }
            $numb = substr($yuan, -1, 1);
            //
            $cncap = ($numb) ? $capnum[$numb] . $capdigit[$j] . $cncap : (($nonzero) ? "零" . $cncap : $cncap);
            $yuan = substr($yuan, 0, strlen($yuan) - 1);
            $j++;
        }
        //合并连续“零”
        $cncap = str_replace("一十", "十", $cncap);
        $cncap = str_replace("一百", "百", $cncap);
        $cncap = str_replace("一千", "千", $cncap);
        $cncap = preg_replace("/(零)+/", "\\1", $cncap);
        return $cncap;
    }


    private function parse($cString)
    {

        preg_match("/(.*?)亿(.*)/", $cString, $match);

        //如果有 拆分
        if ($match != null) {

            $number1 = $this->parse($match[1]);

            $number2 = $this->parse($match[2]);

            return $number1 * 100000000 + $number2;

        }

        preg_match("/(.*?)万(.*)/", $cString, $match);

        //如果有 拆分
        if ($match != null) {

            $number1 = $this->parse($match[1]);

            $number2 = $this->parse($match[2]);

            return $number1 * 10000 + $number2;
        }
        preg_match("/(.*?)千(.*)/", $cString, $match);

        //如果有 拆分
        if ($match != null) {

            $number1 = $this->parse($match[1]);

            $number2 = $this->parse($match[2]);

            return $number1 * 1000 + $number2;
        }

        preg_match("/(.*?)百(.*)/", $cString, $match);

        //如果有就拆分
        if ($match != null) {

            $number1 = $this->parse($match[1]);

            $number2 = $this->parse($match[2]);

            return $number1 * 100 + $number2;
        }

        preg_match("/(.*?)十(.*)/", $cString, $match);

        //如果有就拆分
        if ($match != null) {

            $number1 = $this->parse($match[1]);

            $number2 = $this->parse($match[2]);

            return $number1 * 10 + $number2;
        }

        preg_match("/(.*)/", $cString, $match);

        if ($match != null) {

            $res = array();

            foreach ($this->chinesnumber as $i => $j) {
                $res[$i] = "/" . $j . "/";
            }

            $number = preg_replace($res, $this->arabicnumber, $match[1]);

            return $number;
        }

    }


}

?>
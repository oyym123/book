<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/4/14
 * Time: 10:35
 */

namespace App\controller;


class ArticleController
{
    public function index()
    {
        \FuncController::render();
    }

    /** 获取单个章节 */
    public function chapter()
    {
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        $chapter = $mysql->where(['article_id' => $id])->order('chapter_id')->limit($limit + 1  , 5)->select('chapter');
        foreach ($chapter as $item) {
            $item['content'] = htmlspecialchars($item['content']);
        }
        \FuncController::render('index', $chapter);
    }

    /** 获取所有的章节 */
    public function get1()
    {
        // 获取链接的HTML代码
        $html = file_get_contents('https://www.biquge5200.com/11_11782/');
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);
        $hrefs = $xpath->evaluate('/html/body//a');
        //for ($i = 0; $i < 3; $i++) {
        for ($i = 0; $i < $hrefs->length; $i++) {
            $href = $hrefs->item($i);
            $url = $href->getAttribute('href');
            // 保留以http开头的链接
            if (substr($url, 0, 4) == 'http')
                // echo $url . '<br/>';
                $this->check($url);
        }
    }


    /** 获取所有的章节 */
    public function get()
    {
        // 获取链接的HTML代码
        $html = file_get_contents('https://www.biquge5200.com/83_83599/');
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $hrefs = $xpath->evaluate('/html/body//a');
        //for ($i = 0; $i < 3; $i++) {
        for ($i = 0; $i < $hrefs->length; $i++) {
            $href = $hrefs->item($i);
            $url = $href->getAttribute('href');
            // 保留以http开头的链接
            if (substr($url, 0, 4) == 'http')
                $article = $mysql->where(['url' => $url])->select('chapter');
            if (empty($article)) {
                $this->check($url);
            }
        }
    }

    public function check($url)
    {
        set_time_limit(0);
        sleep(5);
        //初始化
        $curlobj = curl_init();
        //设置访问的url
        curl_setopt($curlobj, CURLOPT_URL, $url);
        //执行后不直接打印出
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);

        //设置https 支持
        date_default_timezone_get('PRC');   //使用cookies时，必须先设置时区
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0);  //终止从服务端验证

        $output = curl_exec($curlobj);  //执行获取内容
        curl_close($curlobj);          //关闭curl

        //取得指定位址的內容，并储存至 $text
        //  $text=file_get_contents('http://www.jb51.net/');
        //去除换行及空白字符（序列化內容才需使用）
        //$text=str_replace(array("/r","/n","/t","/s"), '', $text);

        $output = iconv('GBK', 'UTF-8', $output);
        $regex1 = "/<div id=\"content\".*?>.*?<\/div>/ism";
        preg_match("/(第)(.*)(?)(章)/", $output, $chapter);
        preg_match("/<title>(.*?)<\/title>/", $output, $title);
        if (preg_match($regex1, $output, $matches)) {
            $title = str_replace(" ", "||", $title[1]);
            $content = str_replace('<br/>', '|**|', $matches[0]);
            $content = str_replace("\r\n", '', $content);
            $content = str_replace("        ", "", $content);
            $title = str_replace("_笔趣阁", "", $title);
            $content = str_replace("想看好看的小说，请使用微信关注公众号“得牛看书”。", "", $content);

            if (!is_numeric($chapter[2])) {
                $s = new \ChineseNumberConvModel();
                $chapter_id = $s->toAlpha($chapter[2]);
            } else {
                $chapter_id = $chapter[2];
            }

            $pdo = new \MysqlModel;
            $mysql = $pdo->database();
            $param = [
                'article_id' => 1,
                'chapter_id' => $chapter_id,
                'url' => $url,
                'name' => $title,
                'content' => base64_encode(strip_tags($content)),
                'created_at' => time(),
                'updated_at' => time(),
            ];

            $mysql->insert('chapter', $param);
        } else {
            echo '0';
        }

    }

}
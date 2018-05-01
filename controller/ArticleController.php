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
        $limit = isset($_GET['limit']) ? ($_GET['limit'] ?: 1) : 0;
        $user_id = \UserModel::isLogin();
        $article = $mysql->where(['id' => $id])->one('article');
        $chapter = $mysql->where(['article_id' => $id])->order('chapter_id')->limit($limit, 5)->all('chapter');
        $record = [
            'user_id' => $user_id,
            'article_id' => $id,
            'title' => $article['title'],
            'author' => $article['author'],
            'chapter_id' => ($limit ?: 1) * 5,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $recordRes = $mysql->where(['article_id' => $id])->one('reading_record');
        if ($recordRes) {
            $mysql->where(['id' => $recordRes['id']])->update('reading_record', $record);
        } else {
            $mysql->insert('reading_record', $record);
        }
        \FuncController::render('index', ['limit' => $limit, 'chapter' => json_encode($chapter), 'title' => $article['title']]);
    }


    public function search()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $url = 'https://www.biquge5200.com/modules/article/search.php?searchkey=' . $search;
        $output = self::getInfo($url);
        preg_match_all("/<td class=\"odd\"><a href=\"(.*)(?)\">(.*)(?)<\/a><\/td>/", $output, $name);
        preg_match_all("/<\/td>
    <td class=\"odd\">(.*)(?)<\/td>/", $output, $author);
        foreach ($name[2] as $key => $item) {
            $param[] = [
                'name' => $item,
                'url' => $name[1][$key],
                'author' => $author[1][$key]
            ];
        }
        \FuncController::render('search', ['param' => json_encode($param)]);
    }


    //站内搜索
    public function siteSearch()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();
        // $article = $mysql->where(['title' => "'$search'"])->select('article');
        $article = $mysql->doSql('SELECT * FROM article WHERE title LIKE ' . "'%$search%'");
        \FuncController::render('site-search', ['param' => json_encode($article)]);
    }

    /** 等待界面 */
    public function loading()
    {
        $param = [
            'url' => isset($_GET['url']) ? $_GET['url'] : '',
            'title' => isset($_GET['title']) ? $_GET['title'] : '',
            'author' => isset($_GET['author']) ? str_replace(' ', '', $_GET['author']) : ''
        ];
        \FuncController::render('loading', ['param' => json_encode($param)]);
    }

    /** 获取所有的章节 */
    public function get()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $author = isset($_GET['author']) ? str_replace(' ', '', $_GET['author']) : '';

        // 获取链接的HTML代码
        set_time_limit(0);
        ignore_user_abort(true);

        $html = file_get_contents($url);
        $pdo = new \MysqlModel;
        $mysql = $pdo->database();

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $hrefs = $xpath->evaluate('/html/body//a');

        for ($i = 0; $i < $hrefs->length; $i++) {
            $href = $hrefs->item($i);
            $url1 = $href->getAttribute('href');
            // 保留以http开头的链接
            if (substr($url1, 0, 4) == 'http') {
                $urls[] = $url1;
            }
        }
        $urls = array_unique($urls);
        $articles = [
            'chapter_count' => count($urls),
            'url' => $url,
            'title' => $title,
            'author' => $author,
            'type' => 1,
            'content' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ];

        $article = $mysql->where(['url' => "'$url'"])->field(['title', 'id'])->limit(1)->select('article');

        if (empty($article)) {
            $articles = $mysql->insert('article', $articles);
            $article_id = $articles[0]['@@identity'];
        } else {
            $mysql->where(['id' => $article[0]['id']])->update('article', $articles);
            $article_id = $article[0]['id'];
        }

        foreach ($urls as $l) {
            $article1 = $mysql->where(['url' => "'$l'"])->field(['id'])->select('chapter');
            if (empty($article1)) {
                $this->check($l, $article_id, $title);
            }
        }
    }

    public function check($url, $article_id, $articleTitle)
    {
        set_time_limit(0);
        ignore_user_abort(true);
        header("Location: index.php?c=home&a=index");
        $output = self::getInfo($url);
        $regex1 = "/<div id=\"content\".*?>.*?<\/div>/ism";
        preg_match("/(第)(.*)(?)(章)/", $output, $chapter);

        if (empty($chapter)) {
            preg_match("/<title>(.*)(?)(章)/", $output, $chapter);
            $chapter = $chapter[1];
        } else {
            $chapter = $chapter[2];
        }
        preg_match("/<title>(.*?)<\/title>/", $output, $title);
        if (preg_match($regex1, $output, $matches)) {
            $title = str_replace(" ", "||", $title[1]);
            $content = str_replace('<br/>', '|**|', $matches[0]);
            $content = str_replace("\r\n", '', $content);
            $content = str_replace("        ", "", $content);
            $title = str_replace("_笔趣阁", "", $title);
            $title = str_replace('_' . $articleTitle, "", $title);
            $content = str_replace("想看好看的小说，请使用微信关注公众号“得牛看书”。", "", $content);
            if (!is_numeric($chapter)) {
                $s = new \ChineseNumberConvModel();
                $chapter_id = $s->toAlpha($chapter);
            } else {
                $chapter_id = intval($chapter);
            }
            $pdo = new \MysqlModel;
            $mysql = $pdo->database();
            $param = [
                'article_id' => $article_id,
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


    public static function getInfo($url)
    {
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
        return iconv('GBK', 'UTF-8', $output);
    }

}
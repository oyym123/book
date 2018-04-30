<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>菲菲阅读</title>

    <link rel="stylesheet" type="text/css" href="/public/css/style-home.css">
    <link rel="stylesheet" type="text/css" href="/public/css/search.css">
    <link rel="stylesheet" type="text/css" href="/public/css/jquery-sliding-menu.css">

    <script type="text/javascript" src="/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/jquery-sliding-menu.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#menu').menu();
        });
    </script>
</head>
<body>
<?php
require('../public/header.php');
?>
<section>
    <div id="menu">
        <ul>
            <li>
                <a href="/index.php?c=readingRecord&a=lastViewed">打开上次阅读</a>
            </li>
            <li>
                <a href="#">最近浏览</a>
                <ul>
                    <?php foreach ($data['recently'] as $item) { ?>
                        <a href="/index.php?c=readingRecord&a=lastViewed&id=<?= $item['id'] ?>"><?= $item['title'] . '  /  第 ' . $item['chapter_id'] . ' 章' ?></a>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#">最喜爱的</a>
                <ul>
                    <?php foreach ($data['favorite'] as $item) { ?>
                        <li>
                            <a href="#"><?= $item['title'] ?></a>
                            <ul>
                                <?php for ($i = 1; $i < $item['chapter_count']; $i++) {
                                    if ($i % 5 == 0 || $i == 1) {
                                        ?>
                                        <li>
                                            <a href="/index.php?c=article&a=chapter&id=<?= $item['id'] ?>&limit=<?php if ($i > 1) {
                                                echo $i / 5;
                                            } else {
                                                echo 0;
                                            } ?>"><?= $i ?>
                                                -<?= $i + 5 ?> 章</a>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#">作者</a>
                <ul>
                    <li>
                        <a href="#">黑山老鬼</a>
                        <ul>
                            <li>
                                <a href="#">瘟仙</a>
                            </li>
                            <li>
                                <a href="#">掠天记</a>
                            </li>
                            <li>
                                <a href="#">大劫主</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">天蚕土豆</a>
                        <ul>
                            <li>
                                <a href="#">武动乾坤</a>
                            </li>
                            <li>
                                <a href="#">斗破苍穹</a>
                            </li>
                            <li>
                                <a href="#">大主宰</a>
                            </li>
                            <li>
                                <a href="#">元尊</a>
                            </li>
                        </ul>
                </ul>
            <li>
                <a href="#">分类</a>
                <ul>
                    <li>
                        <a href="#">玄幻</a>
                        <ul>
                            <li>
                                <a href="#">武炼巅峰 /莫默</a>
                            </li>
                            <li>
                                <a href="#">圣墟 /辰东</a>
                            </li>
                            <li>
                                <a href="#">一念永恒 /耳根</a>
                            </li>
                            <li>
                                <a href="#">元尊 /天蚕土豆</a>
                            </li>
                            <li>
                                <a href="#">飞剑问道 /我吃西红柿</a>
                            </li>
                            <li>
                                <a href="#">至尊剑皇 /半步沧桑</a>
                            </li>
                            <li>
                                <a href="#">武炼巅峰 /莫默</a>
                            </li>
                            <li>
                                <a href="#">圣墟 /辰东</a>
                            </li>
                            <li>
                                <a href="#">一念永恒 /耳根</a>
                            </li>
                            <li>
                                <a href="#">元尊 /天蚕土豆</a>
                            </li>
                            <li>
                                <a href="#">飞剑问道 /我吃西红柿</a>
                            </li>
                            <li>
                                <a href="#">至尊剑皇 /半步沧桑</a>
                            </li>
                            <li>
                                <a href="#">武炼巅峰 /莫默</a>
                            </li>
                            <li>
                                <a href="#">圣墟 /辰东</a>
                            </li>
                            <li>
                                <a href="#">一念永恒 /耳根</a>
                            </li>
                            <li>
                                <a href="#">元尊 /天蚕土豆</a>
                            </li>
                            <li>
                                <a href="#">飞剑问道 /我吃西红柿</a>
                            </li>
                            <li>
                                <a href="#">至尊剑皇 /半步沧桑</a>
                            </li>
                            <li>
                                <a href="#">武炼巅峰 /莫默</a>
                            </li>
                            <li>
                                <a href="#">圣墟 /辰东</a>
                            </li>
                            <li>
                                <a href="#">一念永恒 /耳根</a>
                            </li>
                            <li>
                                <a href="#">元尊 /天蚕土豆</a>
                            </li>
                            <li>
                                <a href="#">飞剑问道 /我吃西红柿</a>
                            </li>
                            <li>
                                <a href="#">至尊剑皇 /半步沧桑</a>
                            </li>
                        </ul>

                    </li>
                </ul>
            </li>
            <li>
                <a href="#">设置</a>
                <ul>
                    <li>
                        <a href="#">Profile</a>
                    </li>
                    <li>
                        <a href="#">Player</a>
                        <ul>
                            <li>
                                <a href="#">Volume</a>
                            </li>
                            <li>
                                <a href="#">Equalizer</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</section>
</body>
</html>

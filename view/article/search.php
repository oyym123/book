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


<style>
    body {
        background-image: url("/public/image/bgnoise_lg.jpg");
    }
</style>
<body>

<link rel="stylesheet" href="/public/css/weui.css"/>
<div class="weui-mask" id="mask" style="display: none;"></div>
<div class="page">
    <div id="dialogs">
        <!--BEGIN dialog2-->
        <div class="js_dialog" id="iosDialog1" style="display: none;">
            <div class="weui-dialog">
                <div class="weui-dialog__bd"></div>
                <div class="weui-dialog__ft">
                    <a href="/index.php" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
    </div>
</div>
<?php
require('../public/header.php');
?>
<section>
    <div id="menu">
        <ul>
            <?php
            if ($data) {
                foreach ($data as $value) {
                    $author = strip_tags($value['author']);
                    ?>
                    <li>
                        <a href="<?= '/index.php?c=article&a=loading&url=' . $value['url'] . '&title=' . $value['name'] . '&author=' . $author ?>"><?= $value['name'] ?>
                            &nbsp;&nbsp;&nbsp;/&nbsp;<?= $author ?></a>
                    </li>
                    <?php
                }
            } ?>
        </ul>
    </div>
</section>
</body>
</html>
<script type="text/javascript">
    $(function () {
        <?php if (!$data) {
        echo "dialog(data = '没有此内容哦，亲！');";
    } ?>
        function dialog(data='') {
            var $iosDialog1 = $('#iosDialog1');
            $('.weui-dialog__bd').html(data);
            var $mask = $('#mask');
            $('#dialogs').on('click', '.weui-dialog__btn', function () {
                $(this).parents('.js_dialog').fadeOut(200);
                $mask.fadeOut(200);
            });
            $mask.fadeIn(200);
            $iosDialog1.fadeIn(200);
        }
    });
</script>


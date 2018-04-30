<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>菲菲读书-<?= isset($_POST['title']) ? base64_decode($_POST['title']) : '' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Accordion with CSS3"/>
    <meta name="keywords" content="accordion, css3, sibling selector, radio buttons, input, pseudo class"/>
    <meta name="author" content="Codrops"/>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="/public/css/demo.css"/>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/public/css/button-top.css"/>
    <script type="text/javascript" src="/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/modernizr.custom.29473.js"></script>
    <script type="text/javascript" src="/public/js/button-top.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
</head>
<style>
    input:checked ~ article.ac-large {
        height: 100%;
    }

    #div1 {
        line-height: 1.5em;
        letter-spacing: .1em;
    }

    body {
        background-image: url("/public/image/bgnoise_lg.jpg");
    }

    @-webkit-keyframes run {
        from {
            -webkit-transform: rotate(0deg);
        }
        to {
            -webkit-transform: rotate(360deg);
        }
    }

    .image1:hover {
        -webkit-animation-play-state: paused;
    }

    .image1 {
        width: 65px;
        height: 65px;
        border-radius: 65px;
        -webkit-animation: run 6s linear 0s infinite;
    }


</style>
<div class="cd-top" style="z-index: 9999">Top</div>
<body>
<header>
    <p class="codrops-demos">
        <a class="current-demo" href="/index.php">返回主页</a>
    </p>
</header>
<?php if (isset($_POST['chapter'])) {
    $data = json_decode(base64_decode($_POST['chapter']), true);
}
?>

<script>
    $(".search").click(function () {
        window.location.href = "/index.php?c=article&a=chapter&id=" + <?= $data[0]['article_id'] ?> +'&limit=' + $("#search").val();
    });
</script>
<div class="container">

    <section class="ac-container">
        <?php if (isset($_POST['chapter'])) {
        foreach ($data as $key => $item) {
        ?>　
        <div id='article'
        ">
        <input id="ac-<?= $item['id'] ?>" name="accordion-1" type="checkbox"/>
        <label for="ac-<?= $item['id'] ?>"><?= str_replace('||', "&nbsp;&nbsp;", $item['name']); ?></label>
        <article class="ac-large" id="ac-larger-<?= $item['id'] ?>">
            <p id="div1"> <?= str_replace('|**|', '<br/>', base64_decode($item['content'])); ?></p>
        </article>
</div>
<?php }
} ?>
</section>
</div>
<p class="codrops-demos">
    <?php
    if (isset($_POST['chapter']) && isset($_POST['limit'])) {
        $limit = base64_decode($_POST['limit']);
        if (isset($data[0]['article_id'])) {
            echo '<a class="current-demo" href="/index.php?c=article&a=chapter&id=' . $data[0]['article_id'] . '&limit=' . ($limit + 1) . '"  > 第 ' . $limit * 5 . ' - ' . (($limit * 5) + 5) . '</a>';
        }
    } ?>
</p>
</body>
</html>
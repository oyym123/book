<style>
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
<?php
if (isset($_POST['param'])) {
    $data = json_decode(base64_decode($_POST['param']), true);
} else {
    header("Location: /index.php?c=home&a=index");
}
?>
<div style="position: relative">
    <div class="search bar6">
        <form action="">
            <input id="search" type="text" placeholder="书名 或 作者名称   (全网)">
            <button class="all-search" type="button"></button>
        </form>
    </div>

    <img style="position: absolute;margin-top:12%;margin-left: 1% " class="image1"
         src="/public/image/userPhoto.jpg">

    <div class="search bar7">
        <form action="">
            <input id="search1" type="text" placeholder="书名 或 作者名称  (全站)">
            <button class="site-search" type="button"></button>
        </form>
    </div>
</div>
<script>
    $(".all-search").click(function () {
        window.location.href = "/index.php?c=article&a=search&search=" + $("#search").val();
    });
    $(".site-search").click(function () {
        window.location.href = "/index.php?c=article&a=siteSearch&search=" + $("#search1").val();
    });
</script>
<div class="search bar8">
    <form action="">
        <input type="text" placeholder="输入第几章，自动跳转">
        <button type="submit"></button>
    </form>
</div>
<h2 style="font-size: larger">&nbsp;&nbsp;<?= isset($_SESSION['nick_name']) ? $_SESSION['nick_name'] : '' ?></h2>

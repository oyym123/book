<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon"
          href="http://simbyone.com/wp-content/uploads/2014/04/3455e6f65c33232a060c28829a49b1cb.png">
    <title>Page Preloading Effects</title>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        #loading {
            background-color: #17607d;
            height: 100%;
            width: 100%;
            position: fixed;
            z-index: 1;
            margin-top: 0px;
            top: 0px;
        }

        #loading-center {
            width: 100%;
            height: 100%;
            position: relative;
        }

        #loading-center-absolute {
            position: absolute;
            left: 50%;
            top: 50%;
            height: 200px;
            width: 200px;
            margin-top: -100px;
            margin-left: -100px;
            -ms-transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            transform: rotate(-135deg);

        }

        .object {
            -moz-border-radius: 50% 50% 50% 50%;
            -webkit-border-radius: 50% 50% 50% 50%;
            border-radius: 50% 50% 50% 50%;
            position: absolute;
            border-top: 5px solid #FFF;
            border-bottom: 5px solid transparent;
            border-left: 5px solid #FFF;
            border-right: 5px solid transparent;

            -webkit-animation: animate 2s infinite;
            animation: animate 2s infinite;

        }

        #object_1 {
            left: 85px;
            top: 85px;
            width: 30px;
            height: 30px;

        }

        #object_one {
            left: 75px;
            top: 75px;
            width: 50px;
            height: 50px;
        }

        #object_two {
            left: 65px;
            top: 65px;
            width: 70px;
            height: 70px;
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        #object_three {
            left: 55px;
            top: 55px;
            width: 90px;
            height: 90px;
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s;
        }

        #object_four {
            left: 45px;
            top: 45px;
            width: 110px;
            height: 110px;
            -webkit-animation-delay: 0.6s;
            animation-delay: 0.6s;

        }

        @-webkit-keyframes animate {

            50% {

                -ms-transform: rotate(360deg) scale(0.8);
                -webkit-transform: rotate(360deg) scale(0.8);
                transform: rotate(360deg) scale(0.8);
            }

        }

        @keyframes animate {
            50% {

                -ms-transform: rotate(360deg) scale(0.8);
                -webkit-transform: rotate(360deg) scale(0.8);
                transform: rotate(360deg) scale(0.8);
            }
        }
    </style>
</head>
<body>
<div id="loading">
    <div id="loading-center">
        <h1 style="font-size: 5em;color: #7F8C8D"> 数据加载中。。。</h1>
        <div id="loading-center-absolute">
            <div class="object" id="object_four"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_one"></div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    <?php
    if(isset($_POST['param'])){
    $data = json_decode(base64_decode($_POST['param']), true);
    ?>
    setTimeout(function () {
        url = "<?php echo '/index.php?c=article&a=get&url=' . $data['url'] . '&title=' . $data['title'] . '&author=' . $data['author'] ?>";
        window.location.href = url;
    }, 1000);

    setTimeout(function () {
        window.location.href = '/index.php';
    }, 2000);
    <?php
    }?>
</script>

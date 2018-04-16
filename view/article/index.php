<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>富贵不能吟 1-5章节</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Accordion with CSS3"/>
    <meta name="keywords" content="accordion, css3, sibling selector, radio buttons, input, pseudo class"/>
    <meta name="author" content="Codrops"/>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="/public/css/demo.css"/>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css"/>
    <script type="text/javascript" src="/public/js/modernizr.custom.29473.js"></script>
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

</style>
<body>

<div class="container">
    <header>
        <p class="codrops-demos">
            <a class="current-demo" href="index.php">返回上页</a>
        </p>
    </header>

    <section class="ac-container">
        <?php if ($_POST['param']) {
            foreach (json_decode($_POST['param'], true) as $key => $item) {
                ?>　
                <div id='article'>
                    <input id="ac-<?= $item['id'] ?>" name="accordion-1" type="checkbox"/>
                    <label for="ac-<?= $item['id'] ?>"><?= str_replace('||', '　　', $item['name']); ?></label>
                    <article class="ac-large" id="ac-larger-<?= $item['id'] ?>">
                        <p id="div1"> <?= str_replace('|**|', '<br/>', base64_decode($item['content'])); ?></p>
                    </article>
                </div>
            <?php }
        } ?>
    </section>
</div>
</body>
</html>

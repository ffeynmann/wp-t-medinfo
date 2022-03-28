<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php wp_title() ?></title>
<!--    <meta name="description" content="--><?//= $description ?><!--">-->
    <link rel="icon" href="<?= \App\Base::$url ?>/dist/images/favicon.ico" type="image/x-icon">
    <?php \App\Posts::postsCannonical() ?>
    <?php \App\Posts::ogImage() ?>
<!--    <link rel="alternate" href="http://example.com/" hreflang="x-default" />-->


<!--    <meta property="og:url"         content="--><?//= $_SERVER['REQUEST_URI'] ?><!--" />-->
<!--    <meta property="og:type"        content="article" />-->
<!--    <meta property="og:title"       content="--><?//= $app->seo->title(false) ?><!--" />-->
<!--    <meta property="og:description" content="--><?//= $description ?><!--" />-->
<!--    <meta property="og:image"       content="--><?//= $app->seo->image() ?><!--" />-->
    <?php wp_head() ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VMY9611C49"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-VMY9611C49');
    </script>
    <meta name="google-site-verification" content="K8hugyu1UJXMHuHoxmPQsm8hjcBFZYM09253FKM8290" />
</head>
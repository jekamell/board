<? /* @var $this Controller */ ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= CHtml::encode(Yii::app()->name) ?></title>
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
</head>

<body>
    <? $this->renderPartial('//partials/_top-menu', null, false, true); ?>

    <div class="container">
        <?= $content; ?>
    </div><!-- /.container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>

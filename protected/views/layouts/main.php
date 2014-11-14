<? /* @var $this Controller */ ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= CHtml::encode(Yii::app()->name) ?></title>
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?= CHtml::encode(Yii::app()->name)?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <? if (Yii::app()->user->getIsGuest()) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Auth <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?= CHtml::link('Sign up', '#'); ?></li>
                                <li><?= CHtml::link('Register now', $this->createUrl('/user/register')); ?></li>
                            </ul>
                        </li>
                    <? } else { ?>
                        <li><?= CHtml::link(Yii::app()->user->email, '#'); ?></li>
                    <? } ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        <?= $content; ?>
    </div><!-- /.container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= CHtml::link(Yii::app()->name, Yii::app()->getBaseUrl(true), ['class' => 'navbar-brand']) ?>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <? if (!Yii::app()->getUser()->getIsGuest()) { ?>
                    <li><a href="#contact">My products</a></li>
                <? } ?>
                <li><a href="#contact">Add product</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <? if (Yii::app()->user->getIsGuest()) { ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Auth <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><?= CHtml::link('Sign up', $this->createUrl('/user/login')); ?></li>
                            <li><?= CHtml::link('Register now', $this->createUrl('/user/register')); ?></li>
                        </ul>
                    <? } else { ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <?= sprintf('%s (%s)', Yii::app()->getUser()->name, Yii::app()->getUser()->email); ?>
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><?= CHtml::link('Edit profile', $this->createUrl('/user/profile')); ?></li>
                            <li><?= CHtml::link('Logout', $this->createUrl('/user/logout')); ?></li>
                        </ul>
                    <?  } ?>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
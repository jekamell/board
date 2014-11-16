<? if ($result) { ?>
    <p>Congratulation, your account activated</p>
    <p>Please use <?= CHtml::link('login form', $this->createUrl('/user/login')) ?> to sign up</p>
<? } else { ?>
    <p>Confirmation error. Please try again later!</p>
<? } ?>
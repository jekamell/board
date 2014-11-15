<?php
/* @var $this ProductController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
?>

<div class="alert alert-danger">
    <h2>Error <?php echo $code; ?></h2>
    <?php echo CHtml::encode($message); ?>
</div>

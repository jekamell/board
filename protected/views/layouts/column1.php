<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
    <? $this->renderPartial('//partials/_flash'); ?>
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>
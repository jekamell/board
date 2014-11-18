<?php
/* @var $model Files */
/* @var $node Contents */
/* @var $this ContentController */
/* @var $show_asset_link boolean */
if($model->status == Files::STATUS_READY && $model->url){
    $ext = strtolower(pathinfo($model->url,PATHINFO_EXTENSION));
    switch($ext):
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':?>
            <a href="<?=$model->url?>" class="image_preview"><img src="<?=$model->url?>" style="height: 100px;" alt="<?=$model->file?>" /></a>
            <?if($node):
                $url = urlencode(Yii::app()->request->getRequestUri());
                ?>
            <?endif?>
            <?break;
        case 'flv':?>
            <div id="video-<?=$model->id?>">Loading the player...</div>
            <script type="text/javascript">
                jwplayer("video-<?=$model->id?>").setup({
                    file: "<?=$model->url?>",
                    image: "<?=Yii::app()->request->baseUrl?>/images/logo.png"
                });
            </script>
            <?break;
        case 'mp3':?>
            <div class="pull-left">
            <div id="video-<?=$model->id?>">Loading the player...</div>
            <script type="text/javascript">
                jwplayer("video-<?=$model->id?>").setup({
                    file: "<?=$model->url?>",
                    height:30
                });
            </script>
            </div>
            <?break;
        case 'm4v':
        default:?>
            <a href="<?=$model->url?>" target="_blank"><i class="icon-file"></i> <?=pathinfo($model->url, PATHINFO_BASENAME)?></a>
        <?break;
    endswitch;
}else{
    ?><span><i class="icon-file"></i> <?=$model->file?></span><?
}?>
<?if($model->info || !empty($show_asset_link)): ?>
    <div class="pull-right">
        &nbsp;
        <?if(!empty($show_asset_link)):?>
            <a href="<?=$this->createUrl("/admin/assets/view",array("id"=>$model->asset->id)) ?>" target="_blank"><i class="icon-paper-clip"></i></a> &nbsp;
        <?endif?>
        <?if($model->info): ?>
            <a href="#" class="" onclick="return Admin.modal.open({
                action:null,
                title:'File info',
                text:'<?foreach($model->info as $name=>$value):?><strong><?=$name?>:</strong> <?=$value?></br /><?endforeach?>'
                })"><i class="icon-info-sign"></i></a> &nbsp;
        <?endif?>
    </div>
<?endif?>

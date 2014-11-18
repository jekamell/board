<? $items = array();
foreach ($model->infoPages as $iPage) {
    $items[] = array(
        'title' => $iPage->name,
        'content' => $this->renderPartial(
            '_info-screen-view',
            array(
                'model' => $iPage
            ),
            true,
            false
        ),
    );
}
if ($items) { ?>
    <? $this->widget(
        'ext.bootstrap-theme.widgets.BTabs',
        array('items' => $items,)
    )?>
<? } ?>

<script>
    function setTabBackground() {
        var wellCurrent = $('div.tab-pane.active').children('div.well');
        wellCurrent.css('background-color', wellCurrent.children('div').css('background-color'));
    }

    $('div.tabbable li').click(function() {
        setTimeout(setTabBackground, 1);
    });

    setTabBackground();
</script>


<?php
$this->breadcrumbs=array(
	'Bots'=>array('bot/index'),
    $model->name=>array('bot/view','id'=>$model->id),
	'Screens'=>array('screen/view','id'=>$model->id),
);

?>
<div class="row">
<div class="span3">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'OPERATIONS'),
        array('label'=>'View Bot / Chat', 'icon'=>'home', 'url'=>array('bot/view','id'=>$model->id),),
        array('label'=>'View Screenshots', 'icon'=>'cog', 'url'=>array('screen/view','id'=>$model->id),),
    ),
)); ?>
</div>
<div class="container-fluid">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Request Screen',
    'htmlOptions'=>array('id'=>'reqscreen'),
)); ?>
    <div id="alertreq"></div>
    <div id="thumbs">
    <?php $this->widget('bootstrap.widgets.TbThumbnails', array(
    'dataProvider'=>$dataProvider,
    'template'=>"{items}\n{pager}",
    'itemView'=>'_thumb',
)); ?></div>
</div>
</div>


<script type="text/javascript">
    $('.delete').live('click',function() {
        var btn = $(this);
        btn.button('loading'); // call the loading function
        $.ajax({
            url: '<?php echo CController::createUrl('screen/delete'); ?>&t=0&id='+btn.attr('id'),
            success: function(data) {
                window.open('http://imgur.com/delete/'+btn.attr('id'));
                btn.toggle();
                $('#li'+btn.attr('id')).toggle();
            }
        });
    });
    $('.deletet').live('click',function() {
        var btn = $(this);
        btn.button('loading'); // call the loading function
        $.ajax({
            url: '<?php echo CController::createUrl('screen/delete'); ?>&t=1&id='+btn.attr('id'),
            success: function(data) {
                btn.toggle();
                $('#li'+btn.attr('id')).toggle();
            }
        });
    });
    function reloadthumb(){
        $('#reqscreen').button('reset'); // call the reset function
        $.ajax({
            url: '<?php echo CController::createUrl('screen/thumbs',array('id'=>$model->id)); ?>',
            success: function(data) {
                $('#thumbs').html(data);
            }
        });
    }
    $('#reqscreen').click(function() {
        var btn = $(this);
        btn.button('loading'); // call the loading function
        $.ajax({
            url: '<?php echo CController::createUrl('screen/want',array('id'=>$model->id)); ?>',
            success: function(data) {
                $('#alertreq').html(data);
                setTimeout(function() {
                    reloadthumb();
                }, 20000);
            }
        });
    });
</script>
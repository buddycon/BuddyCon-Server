<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Command
 * Date: 28.09.12
 * Time: 12:13
 * To change this template use File | Settings | File Templates.
 */

/** @var BootActiveForm $form */

$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, // display a larger alert block?
    'fade'=>true, // use transitions?
    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
    ),
));

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'searchForm',
    'type'=>'search',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
<?php echo $form->dropDownListRow($model, 'type', array('Guild', 'Say', 'Yell', 'Whisper', 'Bg'), array('style'=>'width: 100px')
); ?>
<?php echo $form->textFieldRow($model, 'message', array('class'=>'input','style'=>'width: 400px')); ?>
<?php
if($model->type==3)
    echo $form->textFieldRow($model, 'to', array('class'=>'input-medium'));
else
    echo $form->textFieldRow($model, 'to', array('class'=>'input-medium','style'=>"display:none;"));

?>
<?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Go','htmlOptions'=>array('id'=>"replyBtn"))); ?>


<?php $this->endWidget(); ?>
<script type="text/javascript">
    $("#Reply_type").change(function(){
        if(this.value==3) $("#Reply_to").show();
        else $("#Reply_to").hide();
    });
    $('#replyBtn').click(function(){

        $.post("<?php $this->createUrl('bot/view',array('id'=>$model->id)); ?>", { ajax: "repl", message: $("#Reply_message").val(), to: $("#Reply_to").val(), type: $("#Reply_type").val()},
                function(data) {
                    $("#chat").html(data);
                });
    });
</script>
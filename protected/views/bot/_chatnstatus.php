<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(            // display 'create_time' using an expression
            'name'=>'Time',
            'value'=>'date("H:i:s d.m T", $data->sended)',
            'htmlOptions'=>array('style'=>'"width: 140px; color: ".BotController::parseTypeColor( $data->type)', 'class'=>'"adate"'),
            'evaluateHtmlOptions'=>true,
            'class'=>'DataColumn',
        ),
        array(            // display 'create_time' using an expression
            'name'=>'Type',
            'value'=>'BotController::parseType( $data->type)',
            'htmlOptions'=>array('style'=>'"width: 100px; color: ".BotController::parseTypeColor( $data->type)'),
            'evaluateHtmlOptions'=>true,
            'class'=>'DataColumn',
        ),
        array(
            'name'=>'from',
            'header'=>'From',
            'evaluateHtmlOptions'=>true,
            'class'=>'DataColumn',
            'htmlOptions'=>array('style'=>'"width: 150px; color: ".BotController::parseTypeColor( $data->type)'),
        ),
        array(
            'name'=>'message',
            'header'=>'Message',
            'evaluateHtmlOptions'=>true,
            'class'=>'DataColumn',
            'htmlOptions'=>array('style'=>'"color: ".BotController::parseTypeColor( $data->type)'),
        ),
        array(
            //'name'=>'Reply',
            'header'=>'Reply',
            'type'=>'raw',
            'value'=>'"<a href=\"javascript:reply(\'$data->type\',\'$data->from\');\"><i class=\"icon-envelope\"></i></a>"',
            //'evaluateHtmlOptions'=>true,
            //'class'=>'DataColumn',
            //'htmlOptions'=>array('style'=>'"color: ".BotController::parseTypeColor( $data->type)'),
        ),

    ),
)); ?>
<?php
if(count($dataProviderG)>0)
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'dataProvider'=>$dataProviderG,
        'template'=>"{items}\n{pager}",
        //'enablePagination'=>false,
        'columns'=>array(
            'Gathered',
            'Count',
            //array('name'=>'message', 'header'=>'Message'),

        ),
    )); ?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProviderS,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(            // display 'create_time' using an expression
            'name'=>'Time',
            'value'=>'date("H:i:s d.m T", $data->latestupdate)',
            'htmlOptions'=>array('style'=>'width: 100px', 'class'=>'adate'),

        ),
        array('name'=>'message', 'header'=>'Message'),

    ),
)); ?>
<script type="text/javascript">
    function reply(type,to){
        $("#Reply_to").hide();
        switch(type){
            case ("CHAT_MSG_BATTLEGROUND"):
                $("#Reply_type").val(4);
                break;
            case ("CHAT_MSG_BATTLEGROUND_LEADER"):
                $("#Reply_type").val(4);
                break;
            case ("CHAT_MSG_GUILD"):
                $("#Reply_type").val(0);
                break;
            case ("CHAT_MSG_SAY"):
                $("#Reply_type").val(1);
                break;
            case ("CHAT_MSG_WHISPER"):
                $("#Reply_to").show()
                $("#Reply_type").val(3);
                $("#Reply_to").val(to);
                break;
            case ("CHAT_MSG_YELL"):
                $("#Reply_type").val(2);
                break;
        }

    }
</script>
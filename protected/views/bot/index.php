<?php
$this->breadcrumbs=array(
	'Bots',
);


?>
<div class="container-fluid">
<h1>Bots</h1>
<?php
    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed bordered',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        //array('name'=>'name', 'header'=>'Name'),
        array(
            'name'=>'New',
            'type'=>'html',
            'htmlOptions'=>array('style'=>'width: 40px'),
            'value'=>function($data,$row){ // declare signature so that we can use $data, and $row within this function
                $chat = Chat::model()->countByAttributes(array('bot_id'=>$data->id),'sended > :last',array('last'=>$data->lastvisit));
                $status = Status::model()->countByAttributes(array('bot_id'=>$data->id),'latestupdate > :last  AND message NOT LIKE "Xp gain: %"',array('last'=>$data->lastvisit));

                $ret = $chat+$status;
                return $ret;
            } ),
        array(            // display 'create_time' using an expression
            'name'=>'Name',
            'type'=>'html',
            'value'=>'CHtml::link("$data->name",array("bot/view","id"=>"$data->id"))',
        ),
        array('name'=>'level', 'header'=>'Level'),

        array(
            'name'=>'XP',
            'type'=>'html',
            'htmlOptions'=>array('style'=>'width: 240px'),
            'value'=>function($data,$row){ // declare signature so that we can use $data, and $row within this function
                if($data->level > 89) return "Max";
                    if($data->xp > 0 && $data->xp_needed > 0 && $data->xp < $data->xp_needed){
                        $per = round($data->xp / $data->xp_needed * 100);
                        $ret = $data->xp.' / '.$data->xp_needed.'
                <div class="progress progress-striped">
                    <div class="bar" style="width: '.$per.'%;"></div>
                </div>';
                    }
                    else $ret = "Error?! Please post this to the author: ".$data->id." - ".$data->xp." - ".$data->xp_needed;
                    return $ret;
        } ),
        array(
            'name'=>'Gold',
            'type'=>'html',
            'htmlOptions'=>array('style'=>'width: 250px'),
            'value'=>function($data,$row){
                $ret = "";
                $gold = $data->gold;

                $c = $gold % 100;
                $gold = (int)($gold/100);
                $s = $gold % 100;
                $gold = (int)($gold/100);
               $ret .= $gold."g ".$s."s ".$c."c";
            return $ret;
        } ),
        array(            // display 'create_time' using an expression
            'name'=>'Last update',
            'evaluateHtmlOptions'=>true,
            'class'=>'DataColumn',
            'value'=>'date("H:i:s d.m T", $data->latestupdate)',
            'htmlOptions'=>array('class'=>'"adate"', 'style'=>'"color: ".(($data->latestupdate+30>=time())?"green":(($data->latestupdate+60>=time())?"orange":"red"))'),

        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>"{view} {delete}",
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>
</div>
     <script type="text/javascript">
         $(document).ready(function() {

             $(".adate").each(function() {
                 var datestr = $(this).text();
                 var parts = datestr.match(/(\d+)/g);
                 var d = new Date();

                 d.setUTCMonth(parts[4]);
                 d.setUTCHours(parts[0]-1);
                 d.setUTCMinutes(parts[1]);
                 d.setUTCSeconds(parts[2]);
                 d.setUTCDate(parts[3]);

                 newDateStr = ((d.getHours() < 10)?"0"+d.getHours():""+d.getHours())+":"+ ((d.getMinutes()<10)?"0"+d.getMinutes():""+d.getMinutes())+":"+ ((d.getSeconds()<10)?"0"+d.getSeconds():""+d.getSeconds());//+" "+((d.getDay()<10)?"0"+d.getDay():""+d.getDay()) +"."+ ((d.getMonth()<10)?"0"+d.getMonth():""+d.getMonth());
                 $(this).text(newDateStr);
             });
         });
</script>

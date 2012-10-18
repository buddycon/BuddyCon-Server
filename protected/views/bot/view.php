<?php
$this->breadcrumbs=array(
	'Bots'=>array('index'),
	$model->name,
);

?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span2">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'OPERATIONS'),
        array('label'=>'View Bot / Chat', 'icon'=>'home', 'url'=>array('bot/view','id'=>$model->id),),
        array('label'=>'View Screenshots', 'icon'=>'cog', 'url'=>array('screen/view','id'=>$model->id),),
    ),
)); ?>
</div>

    <div class="span10">
<h1>View Bot <?php echo $model->name; ?></h1>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Clear Chat',
    'htmlOptions'=>array('id'=>'clChat'),
)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Clear Status',
    'htmlOptions'=>array('id'=>'clStatus'),
)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Stop HB',
    'htmlOptions'=>array('id'=>'HBstop'),
)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Start HB',
    'htmlOptions'=>array('id'=>'HBstart'),
)); ?>
<?php
function progress($data){ // declare signature so that we can use $data, and $row within this function
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
}
function goldie($data){
    $ret = "";
    $gold = $data->gold;
    $c = $gold % 100;
    $gold = (int)($gold/100);
    $s = $gold % 100;
    $gold = (int)($gold/100);
    $ret .= $gold."g ".$s."s ".$c."c";
    return $ret;
}
$attr = array(
    'name',
    'level',);

        if($model->level < 90) $attr[] = array(
        'name'=>'XP',
        'type'=>'html',
        'htmlOptions'=>array('style'=>'width: 250px'),
        'value'=> progress($model));
        $attr[] =    array(
        'name'=>'Gold',
        'type'=>'html',
        'htmlOptions'=>array('style'=>'width: 250px'),
        'value'=>goldie($model) );
        $attr[] =  array(            // display 'create_time' using an expression
        'name'=>'Last update',
            'type'=>'html',
            'value'=>"<div class ='adate' style='color: ".(($model->latestupdate+30>=time())?"green":(($model->latestupdate+60>=time())?"orange":"red"))."'>".date('H:i:s d.m T', $model->latestupdate)."</div>",


            //'htmlOptions'=>array('class'=>"adate", 'style'=>"color: ".(($model->latestupdate+30>=time())?"green":(($model->latestupdate+60>=time())?"orange":"red"))),
    );
        $attr[] =    array(            // display 'create_time' using an expression
        'name'=>'Running (min)',
        'value'=>$model->running/60,
    );
        /*
            $bot->timetolevel=$_POST['timeolevel'];
            $bot->xph           = $_POST['xph'];
            $bot->kills         =$_POST['kills'];
            $bot->killsh=$_POST['killsh'];
            $bot->honor=$_POST['honor'];
            $bot->honorh=$_POST['honorh'];
            $bot->death=$_POST['death'];
            $bot->deathh=$_POST['deathh'];
            $bot->bgwin=$_POST['bgwin'];
            $bot->bglost=$_POST['bglost'];
         */

        if($model->timetolevel>0)$attr[] = array(
            'name'=>'Time to level (min)',
            'value'=>$model->timetolevel/60,
        );
        if($model->xph>0)$attr[] = array(
            'name'=>'Xp/h',
            'value'=>$model->xph,
        );
        if($model->kills>0)$attr[] = array(
            'name'=>'Kills/h | Total',
            'value'=>$model->killsh.' | '.$model->kills,
        );
        if($model->honor>0)$attr[] = array(
            'name'=>'Honor/h | Total',
            'value'=>$model->honorh.' | '.$model->honor,
        );
        if($model->death>0)$attr[] = array(
            'name'=>'Death/h | Total',
            'value'=>$model->deathh.' | '.$model->death,
        );
        if($model->bgwin>0 || $model->bglost>0)$attr[] = array(
            'name'=>'BGs won | lost',
            'value'=>$model->bgwin.' | '.$model->bglost,
        );
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
    'type'=>'striped bordered condensed',
	'attributes'=>$attr,
)); ?>

        <div class="well">
            Filter<br/>
            <label style="display: inline;">Guild   <input class="filter" name="guild" id="FilterChat_guild" type="checkbox" <?php if($filter->guild=="true") { ?>checked="true"<?php } ?>></label>
            <label style="display: inline;">BG      <input class="filter" name="bg" id="FilterChat_bg" type="checkbox" <?php if( $filter->bg=="true") { ?>checked="true"<?php } ?>></label>
            <label style="display: inline;">Say     <input class="filter" name="say" id="FilterChat_say" type="checkbox" <?php if( $filter->say=="true") { ?>checked="true"<?php } ?>></label>
            <label style="display: inline;">Yell    <input class="filter" name="yell" id="FilterChat_yell" type="checkbox" <?php if( $filter->yell=="true") { ?>checked="true"<?php } ?>></label>
        </div>

        <div id="chat">
            <?php echo $this->renderPartial('_chat', array(
            'model'=>$chatModel,
        )); ?>
        </div>
<div id="chatnstatus">
    <?php echo $this->renderPartial('_chatnstatus', array(
    'dataProvider'=>$dataProvider,
    'dataProviderS'=>$dataProviderS,
    'dataProviderG'=>$dataProviderG,
)); ?>
</div>
</div>
</div>
</div>
    <script type="text/javascript">
    $(document).ready(function() {


        $(".adate").each(function() {
            var datestr = $(this).text();
            var parts = datestr.match(/(\d+)/g);
            var d = new Date();

           //d.setUTCDate(parts[3]);
           // console.log("date: "+d.getDay()+"."+d.getMonth());
            d.setUTCMonth(parts[4],parts[3]);
            console.log("date: "+d.getDay()+"."+d.getMonth());
            d.setUTCHours(parts[0]-1);
            console.log("date: "+d.getDay()+"."+d.getMonth());
            d.setUTCMinutes(parts[1]);
            d.setUTCSeconds(parts[2]);


            newDateStr = ((d.getHours() < 10)?"0"+d.getHours():""+d.getHours())+":"+ ((d.getMinutes()<10)?"0"+d.getMinutes():""+d.getMinutes())+":"+ ((d.getSeconds()<10)?"0"+d.getSeconds():""+d.getSeconds())+" "+((d.getDate()<10)?"0"+d.getDate():""+d.getDate()) +"."+ ((d.getMonth()<10)?"0"+d.getMonth():""+d.getMonth());
            $(this).text(newDateStr);
        });

        var dorefresh = true;
<?php if(!isset($_GET['Status_page']) && !isset($_GET['Chat_page'])) { ?>
        setInterval(function() {
            if(dorefresh){
                var ret = new Array();
                $('.filter').each(function(){
                    ret[$(this).attr('name')] = $(this).is(':checked');
                });
                $.post("<?php $this->createUrl('bot/view',array('id'=>$model->id)); ?>", {
                    ajax: "true",
                    guild: ret['guild'],
                    bg: ret['bg'],
                    say: ret['say'],
                    yell: ret['yell']
                },
                        function(data) {
                            $("#chatnstatus").html(data);
                            $(".adate").each(function() {
                                var datestr = $(this).text();
                                var parts = datestr.match(/(\d+)/g);
                                var d = new Date();

                                d.setUTCMonth(parts[4]);
                                d.setUTCHours(parts[0]-1);
                                d.setUTCMinutes(parts[1]);
                                d.setUTCSeconds(parts[2]);
                                d.setUTCDate(parts[3]);

                                newDateStr = ((d.getHours() < 10)?"0"+d.getHours():""+d.getHours())+":"+ ((d.getMinutes()<10)?"0"+d.getMinutes():""+d.getMinutes())+":"+ ((d.getSeconds()<10)?"0"+d.getSeconds():""+d.getSeconds())+" "+((d.getDate()<10)?"0"+d.getDate():""+d.getDate()) +"."+ ((d.getMonth()<10)?"0"+d.getMonth():""+d.getMonth());
                                $(this).text(newDateStr);
                            });
                        });
            }

        },10000);
<?php } ?>
        $('#clStatus').click(function(){
            $.post("<?php $this->createUrl('bot/view',array('id'=>$model->id)); ?>", { ajax: "clst"},
                    function(data) {
                        $("#chatnstatus").html(data);
                    });
        });
        $('#clChat').click(function(){
            $.post("<?php $this->createUrl('bot/view',array('id'=>$model->id)); ?>", { ajax: "clch"},
                    function(data) {
                        $("#chatnstatus").html(data);
                    });
        });
        $('#HBstart').click(function(){
            $.post("<?php echo $this->createUrl('bot/do',array('id'=>$model->id)); ?>", { ajax: "st"});
        });
        $('#HBstop').click(function(){
            $.post("<?php echo $this->createUrl('bot/do',array('id'=>$model->id)); ?>", { ajax: "sp"});
        });

        $('ul.yiiPager > li > a').click(function(){
            dorefresh = false;
        });



        $('.filter').change(function(){
            var ret = new Array();
            $('.filter').each(function(){
                ret[$(this).attr('name')] = $(this).is(':checked');
            });
            $.post("<?php echo $this->createUrl('bot/view',array('id'=>$model->id)); ?>", {
                        ajax: "true",
                        guild: ret['guild'],
                        bg: ret['bg'],
                        say: ret['say'],
                        yell: ret['yell']
                    },
                    function(data) {
                        $("#chatnstatus").html(data);
                    });
        });

    });
    </script>

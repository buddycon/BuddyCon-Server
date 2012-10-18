<?php
/* "links":{"
original":"http:\/\/i.imgur.com\/wCZGh.jpg","
imgur_page":"http:\/\/imgur.com\/wCZGh","
delete_page":"http:\/\/imgur.com\/delete\/2MJGYIK1mnG1O5L","
small_square":"http:\/\/i.imgur.com\/wCZGhs.jpg","
large_thumbnail":"http:\/\/i.imgur.com\/wCZGhl.jpg"}}

*/
if($data->private){
    if( preg_match('@http://.*@is', $data->link, $subpattern)) $link = $data->link;
    else $link = "http://".$data->link;
    ?>
<li class="span3" id="li<?php echo $data->id; ?>">
    <a href="<?php echo $link; ?>" target="_blank" class="thumbnail" rel="tooltip" data-title="<?php echo date("H:i:s  d.m",$data->uploadedtime); ?>">
        <img src="<?php if($data->thumb) echo str_replace(".jpg","_t.jpg",$link);  else echo $link; ?>" alt="">
    </a>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Delete',
    'size'=>'mini', // null, 'large', 'small' or 'mini'
    'loadingText'=>'deleting...',
    'htmlOptions'=>array('id'=>$data->id, 'class'=>"deletet", 'data-complete-text'=>"finished!"),
)); ?>
</li>
    <?php
}else{
?>
<li class="span3" id="li<?php echo $data->delete; ?>">
    <a href="http://i.imgur.com/<?php echo $data->link; ?>.jpg" target="_blank" class="thumbnail" rel="tooltip" data-title="<?php echo date("H:i:s  d.m",$data->uploadedtime); ?>">
        <img src="http://i.imgur.com/<?php echo $data->link; ?>l.jpg" alt="">
    </a>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Delete',
    'size'=>'mini', // null, 'large', 'small' or 'mini'
    'loadingText'=>'deleting...',
    'htmlOptions'=>array('id'=>$data->delete, 'class'=>"delete", 'data-complete-text'=>"finished!"),
)); ?>
</li>
    <?php } ?>
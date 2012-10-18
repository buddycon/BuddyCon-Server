<?php
$this->breadcrumbs=array(
	'Chats'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Chat','url'=>array('index')),
	array('label'=>'Create Chat','url'=>array('create')),
	array('label'=>'Update Chat','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Chat','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Chat','url'=>array('admin')),
);
?>

<h1>View Chat #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'bot_id',
		'message',
		'type',
		'from',
	),
)); ?>

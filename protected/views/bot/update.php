<?php
$this->breadcrumbs=array(
	'Bots'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bot','url'=>array('index')),
	array('label'=>'Create Bot','url'=>array('create')),
	array('label'=>'View Bot','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Bot','url'=>array('admin')),
);
?>

<h1>Update Bot <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
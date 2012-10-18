<?php
$this->breadcrumbs=array(
	'Bots'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bot','url'=>array('index')),
	array('label'=>'Manage Bot','url'=>array('admin')),
);
?>

<h1>Create Bot</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
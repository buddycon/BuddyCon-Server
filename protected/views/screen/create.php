<?php
$this->breadcrumbs=array(
	'Screens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Screen','url'=>array('index')),
	array('label'=>'Manage Screen','url'=>array('admin')),
);
?>

<h1>Create Screen</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
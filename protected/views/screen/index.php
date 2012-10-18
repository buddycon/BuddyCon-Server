<?php
$this->breadcrumbs=array(
	'Screens',
);

$this->menu=array(
	array('label'=>'Create Screen','url'=>array('create')),
	array('label'=>'Manage Screen','url'=>array('admin')),
);
?>

<h1>Screens</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

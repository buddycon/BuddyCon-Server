<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h1>Create User</h1>
    <?php if($taken){ ?>
<div class="alert in alert-block fade alert-error">Username already taken!</div>
<?php } ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
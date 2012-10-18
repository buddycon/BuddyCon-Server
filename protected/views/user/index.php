<?php
$this->breadcrumbs=array(
	'Account',
);

?>

<div class="row-fluid">
<h1>Account Data</h1>
<div class="span2">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'OPERATIONS'),
      array('label'=>'Edit Passwort', 'icon'=>'user', 'url'=>'#', 'linkOptions'=>array(
            'data-toggle'=>'modal',
            'data-target'=>'#editpw',
        ),),
      array('label'=>'Generate new api key', 'icon'=>'cog', 'url'=>array('user/genapi'),),
    ),
)); ?>
</div>
<div class="span4">
    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'username',
        'apikey',
    ),
)); ?>
</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'editpw')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>Edit password</h3>
</div>

<div class="modal-body">
    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'action'=>array('user/update'),
        'htmlOptions'=>array('class'=>'well'),
    )); ?>
    <?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3','value'=>'')); ?>
    <?php $this->endWidget(); ?>
</div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'primary',
    'label'=>'Save changes',
    'url'=>"#",
    'htmlOptions'=>array('data-dismiss'=>'modal','onClick'=>"
    $('#verticalForm').submit();
    "),
)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
</div>

<?php $this->endWidget(); ?>
</div>
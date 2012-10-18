<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'link',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'delete',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'thumb',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'bot_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'uploadedtime',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'submit'
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

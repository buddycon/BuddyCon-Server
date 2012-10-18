<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delete')); ?>:</b>
	<?php echo CHtml::encode($data->delete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thumb')); ?>:</b>
	<?php echo CHtml::encode($data->thumb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bot_id')); ?>:</b>
	<?php echo CHtml::encode($data->bot_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uploadedtime')); ?>:</b>
	<?php echo CHtml::encode($data->uploadedtime); ?>
	<br />


</div>
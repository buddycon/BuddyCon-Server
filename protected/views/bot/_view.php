<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gold')); ?>:</b>
	<?php echo CHtml::encode($data->gold); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('xp')); ?>:</b>
	<?php echo CHtml::encode($data->xp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('xp_needed')); ?>:</b>
	<?php echo CHtml::encode($data->xp_needed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('latestupdate')); ?>:</b>
	<?php echo CHtml::encode($data->latestupdate); ?>
	<br />

	*/ ?>

</div>
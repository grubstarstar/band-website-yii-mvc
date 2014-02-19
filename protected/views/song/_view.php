<?php
/* @var $this SongController */
/* @var $data Song */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('art_url')); ?>:</b>
	<?php echo CHtml::encode($data->art_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bpm')); ?>:</b>
	<?php echo CHtml::encode($data->bpm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_name')); ?>:</b>
	<?php echo CHtml::encode($data->file_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('waveform_image')); ?>:</b>
	<?php echo CHtml::encode($data->waveform_image); ?>
	<br />


</div>
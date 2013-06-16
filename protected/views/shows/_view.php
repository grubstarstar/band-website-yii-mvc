<?php
/* @var $this ShowsController */
/* @var $data Shows */
?>

<div class="view">

	<div class="negative side_title part"><?php echo CHtml::encode($data->title); ?></div>

	<div><?php echo strftime( "%d %B %Y @ %I:%M %p", strtotime($data->time)); ?></div>

	<div><?php echo CHtml::encode($data->venue); ?></div>

	<div><?php echo CHtml::encode($data->description); ?></div>

	<div><?php echo CHtml::encode($data->url) ?></div>

</div>
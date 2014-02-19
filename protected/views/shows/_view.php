<?php
/* @var $this ShowsController */
/* @var $data Shows */

Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/shows_view.css");

?>

<div class="show_view" timeline_id="<?php echo $data->id ?>">

	<div class="header"><?php echo CHtml::encode($data->title); ?></div>

	<div class="content">

		<div class="date"><em><?php echo strftime( "%d %B %Y from %I:%M %p", strtotime($data->time)); ?></em></div>

		<div class="venue"><a href="<?php echo CHtml::encode($data->url) ?>"><?php echo '@ ' . CHtml::encode($data->venue); ?></a></div>

		<div class="description"><?php echo CHtml::encode($data->description); ?></div>

<?php if(isset($data->fbevent_url)) { ?>
		<div class="fbevent"><a target="_blank" href="<?php echo CHtml::encode($data->fbevent_url) ?>"></a></div>
<?php } ?>
	

	</div>

</div>
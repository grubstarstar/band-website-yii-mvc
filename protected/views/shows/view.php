<?php
/* @var $this ShowsController */
/* @var $model Shows */

$this->breadcrumbs=array(
	'Shows'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Shows', 'url'=>array('index')),
	array('label'=>'Create Shows', 'url'=>array('create')),
	array('label'=>'Update Shows', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Shows', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shows', 'url'=>array('admin')),
);
?>

<h1>View Shows #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'time',
		'venue',
		'description',
		'url',
	),
)); ?>

<?php
/* @var $this ShowsController */
/* @var $model Shows */

$this->breadcrumbs=array(
	'Shows'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Shows', 'url'=>array('index')),
	array('label'=>'Create Shows', 'url'=>array('create')),
	array('label'=>'View Shows', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Shows', 'url'=>array('admin')),
);
?>

<h1>Update Shows <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
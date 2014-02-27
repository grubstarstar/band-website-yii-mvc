<?php
/* @var $this ShowsController */
/* @var $model Shows */

$this->breadcrumbs=array(
	'Shows'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Shows', 'url'=>array('index')),
	array('label'=>'Manage Shows', 'url'=>array('admin')),
);
?>

<h1>Create Shows</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
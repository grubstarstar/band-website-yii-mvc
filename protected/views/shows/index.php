<?php
/* @var $this ShowsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shows',
);

$this->menu=array(
	array('label'=>'Create Shows', 'url'=>array('create')),
	array('label'=>'Manage Shows', 'url'=>array('admin')),
);
?>

<h1>Shows</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

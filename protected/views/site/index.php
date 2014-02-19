<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$new_song = new Song;
$songs = Song::model()->findAll();

// $this->widget('application.components.MWidgets.MPanel', array(
// 	'model_class' => 'Song',
// 	'models'      => $songs,
// 	'is_editable' => Yii::app()->user->id == 'admin',
// 	'view'        => '/song/_songview',
// 	'empty_view'  => '/song/_songview_empty',
// 	'edit_form'   => array(
// 		'/song/_form' => array(
// 				'model' => $new_song,
// 				'isAjax' => true
// 			)
// 		),
// 	'delete'	=> 'deleteSong'
// 	// dataprovider for form???
// ));

?>

<img src="images/sarah_fights_you.jpg" style="width: inherit"/>
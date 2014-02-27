<?php
/* @var $this ShowsController */
/* @var $model Shows */
/* @var $form CActiveForm */

Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shows-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
		<?php
			$this->widget('CJuiDateTimePicker',array(
			        'model'=>$model, //Model object
			        'attribute'=>'time', //attribute name
			        'mode'=>'datetime', //use "time","date" or "datetime" (default)
			        'options'=>array() // jquery plugin options
			    ));
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'venue'); ?>
		<?php echo $form->textField($model,'venue',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'venue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fbevent_url'); ?>
		<?php echo $form->textField($model,'fbevent_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fbevent_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'flyer_jpeg'); ?>
		<?php echo $form->textField($model,'flyer_jpeg'); ?>
		<?php echo $form->error($model,'flyer_jpeg'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
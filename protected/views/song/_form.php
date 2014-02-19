<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'song-form',
	'enableAjaxValidation'=>true,
	'action'=> $model->isNewRecord ? array('song/create') : array('song/update', 'id'=>$model->id),
	'method'=>'post',
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'art_url'); ?>
		<?php echo $form->textField($model,'art_url',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'art_url'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'songFile'); ?>
		<?php echo CHtml::activeFileField($model,'songFile'); ?>
		<?php echo CHtml::error($model,'songFile'); ?>
	</div>

	<div class="row buttons">
		<?php
			// if(isset($isAjax))
			// 	echo CHtml::ajaxSubmitButton(
			// 		//text
			// 		$model->isNewRecord ? 'Create' : 'Save',
			// 		// url
			// 		$model->isNewRecord ? array('song/create') : array('song/update'),
			// 		// ajax options 
			// 		array(
			// 			'context'=>'js:this',
			// 			'dataType'=>'JSON',
			// 			'beforeSend'=>'function() {
			// 				console.log($(this).closest(".mpanel_form"));
			// 				$(this).addClass("loading");
			// 			}',
			// 			'success'=>'function(model) {
			// 				console.log(
			// 					model.id,
			// 					model.title,
			// 					model.group_id,
			// 					model.art_url,
			// 					model.bpm,
			// 					model.file_name,
			// 					model.waveform_image
			// 				);
			// 				if(model.id) {
			// 					// create a new "item container" object here, and slide it in at the bottom
			// 					// $(this).closest(".item_container").slideUp();
			// 				}
			// 			}',
			// 			'error'=>'function(jqXHR, textStatus, errorThrown) {
			// 				console.log(jqXHR.responseText);
			// 			}',
			// 			'complete'=>'function(jqXHR, textStatus) {
			// 				$(this).removeClass("loading");
			// 			}'

			// 		),
			// 		// html options
			// 		array(
			// 			//
			// 		)
			// 	);
			// else
				echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		?>
	</div>

	<!--script>
	// This is another attempt to do file upload over ajax. IT hijacks the CHtml::submitButton's click event
	// rather than using the CHtml::ajaxSubmitButton as is commented out further up.
		// $('#song-form input[type="submit"]').click(function(event){

		// 	var form = $(this).closest('form').get(0);
		// 	var data = new FormData(form);
		// 	$(this).data('form-data', data);

		//     $.ajax({
		// 	    url: '<?php echo CHTML::normalizeUrl($form->action) ?>',
		// 	    data: $(this).data('form-data'),
		// 	    cache: false,
		// 	    contentType: false,
		// 	    processData: false,
		// 	    type: 'POST',
		// 	    dataType: 'json',
		// 	    // This was an attempt to get over the IE issue with "do you want to save or upload from ajax ie blah blah"
		// 	    // cos for some fucking stupid reason IE 9 intercepts your XMLHTTPRequest reponse and asks you if you want
		// 	    // to open it or save it.
		// 	    // beforeSend: function(jqXHR, settings) {
		// 	    // 	console.log("Accept", "application/json, text/javascript, */*; q=0.01");
		//     	// 	jqXHR.setRequestHeader("Accept", "application/json, text/javascript, */*; q=0.01");
		// 	    // },
		// 	    success: function(data, textStatus, jqXHR) {
		// 	        console.log(data); 
		// 	        console.log(textStatus); 
		// 	        console.log(jqXHR); 
		// 	    },
		// 	    complete: function(jqXHR, textStatus) {
		// 	        alert(textStatus);
		// 	    },
		// 	    error: function(jqXHR, textStatus, errorThrown){
		// 	        alert(textStatus);
		// 	    }
		// 	});

		// 	event.preventDefault();
		// });
	</script-->

<?php $this->endWidget(); ?>

</div><!-- form -->
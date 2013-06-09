<?php

class MPanel extends CWidget
{
	public $model_class;
	public $models;
	public $is_editable;
	public $view;
	public $empty_view;
	public $edit_form;
	public $delete;
	
	private $_mpanel_id;

    public function run()
    {
		$this->_mpanel_id = sprintf("panel_%s", uniqid(rand(), false));
		$model_class = ucfirst($this->model_class);
		$model_class_lc = lcfirst($this->model_class);

		// get the parameters.
		$form_params = $this->edit_form;
		$edit_form_name = key($this->edit_form);
		$form_view_params = $form_params[$edit_form_name];

		
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/jplayer.skins/muso.skin/muso.skin2.css");
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/mpanel.css");
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery.jplayer.min.js", CClientScript::POS_HEAD);
		
		// Start the panel html
		?>
		
<div id="<?php echo $this->_mpanel_id; ?>" class="mpanel">
<?php if($this->is_editable): ?>
	<a class="set_edit_mode" href="#"><?php echo 'edit ' . $model_class_lc . 's'; ?></a>
	<a class="edit_mode add_button"><?php echo 'Add a ' . $model_class_lc; ?></a>
<?php endif; ?>
			
		<?php
			if(empty($this->models)) {
				Yii::app()->controller->renderPartial($this->empty_view, array( $model_class_lc => []));
			} else {
				// LOOP through each model
				foreach($this->models as $m) { 
		?>
	<div class="item_container">
		<?php
				// output the view for this $m
					Yii::app()->controller->renderPartial($this->view, array( $model_class_lc => $m, 'is_editable' => $this->is_editable ));
		?>
	</div> <!-- end of item_container -->
		<?php 
				} // END LOOP
			} 
		?>
	
	<div class="mpanel_form">
		<?php
			$form_view_params[$model_class_lc] = new $model_class();
			$form_view_params['action'] = array($model_class_lc . '/create');
			Yii::app()->controller->renderPartial($edit_form_name, $form_view_params);
		?>
	</div>
		
</div>

<script>
	$(document).ready(function() {
		// toggle between edit and view mode.
		$('#<?php echo $this->_mpanel_id ?> a.set_edit_mode').data('edit_mode', false).click(
			function() {
				var mode_switch = $(this);
				$('#<?php echo $this->_mpanel_id ?> .edit_mode, #<?php echo $this->_mpanel_id ?> .view_mode').toggle(0, function() {
					mode_switch.data('edit_mode', !mode_switch.data('edit_mode')).data('edit_mode')
						? mode_switch.html('<?php echo 'view ' . $model_class_lc . 's'; ?>')
						: mode_switch.html('<?php echo 'edit ' . $model_class_lc . 's'; ?>');
				});
				return false;
			}
		);
		
		// hide all edit controls
		$('#<?php echo $this->_mpanel_id ?> .edit_mode').hide();
		
		// stick the mpanel_form at the end of the body for the overlay effect.
		$('body').append($('#<?php echo $this->_mpanel_id ?> .mpanel_form').hide());
		
		// add button action
		$('#<?php echo $this->_mpanel_id; ?> .add_button').click(function() {
			$('body .mpanel_form').toggle();
		});
	});
</script><?php
    }
}

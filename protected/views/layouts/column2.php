<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<div id="sidebar">

		<div class="section">
			<!--form>
				<div class="negative side_title part">SUBSCRIBE</div>
				<div class="part"><input type="email" value="email here" /></div>
				<div class="part"><input type="submit" value="SUBMIT" /></div>
			</form-->

			<?php echo CHtml::beginForm(array('site/subscribe'), 'post', array('id'=>'subscribe')); ?>

			<div class="negative side_title part">SUBSCRIBE</div>

			<div class="part"><?php echo CHtml::textField('email_address', 'email here'); ?></div>

			<div class="part">
				<?php
					echo CHtml::ajaxSubmitButton(
						'Submit',
						array('site/subscribe'),
						array(
							'type' => 'post',
							'update' => '#subscribe_ajax_msg',
						),
						array()
					); ?>
			</div>

				<div id="subscribe_ajax_msg"></div>

			<?php echo CHtml::endForm(); ?>

		</div>

		<div class="section">
			
		</div>

	</div><!-- sidebar -->


	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->


<?php $this->endContent(); ?>
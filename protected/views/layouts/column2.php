<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<div id="sidebar">

		<div class="section">
			<form>
				<div class="negative side_title part">SUBSCRIBE</div>
				<div class="part"><input type="email" value="email here" /></div>
				<div class="part"><input type="submit" value="SUBMIT" /></div>
			</form>
		</div>

		<div class="section">
			
		</div>

	</div><!-- sidebar -->


	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->


<?php $this->endContent(); ?>
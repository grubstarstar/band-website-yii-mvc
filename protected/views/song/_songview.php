<h3 style="margin-bottom: 5px;"><?php echo $song->title; ?></h3>

<div id="jPlayer_<?php echo $song->id ?>" class="jp-jplayer"></div>
<div id="jp_container_<?php echo $song->id ?>" class="jp-audio">
	<div class="jp-type-single">

		<div class="jp-gui jp-interface">
			<div class="jp-controls">
				<div class="controls2">
					<a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a>
					<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				<a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a>
				</div>
				<div class="controls1">
					<a href="javascript:;" class="jp-play" tabindex="1">play</a>
					<a href="javascript:;" class="jp-pause" tabindex="1">pause</a>
					<a href="javascript:;" class="jp-stop" tabindex="1">stop</a>
				</div>
				<div class="jp-progress"<?php echo $song->waveImageUrl ? " style=\"background-image: url('{$song->waveImageUrl}');\"" : ""; ?>>
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
					<div class="jp-time-holder">
						<span class="jp-current-time"></span>/
						<span class="jp-duration"></span>
					</div>
					<span class="jp-toggles">
						<a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a>				    
						<a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a>
					</span>
				</div>
			</div>
		</div>

		<div class="jp-no-solution">
		<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>
		</div>

	</div>
</div>

<?php
	if($is_editable) {
		echo CHtml::ajaxLink(
			// text
			"Remove Song",
			// url
			array('song/delete', 'id' => $song->id),
			// ajax options 
			array(
				'type'=>'POST',
				'context'=>'js:this',
				'dataType'=>'JSON',
				'beforeSend'=>'function() {
					$(this).addClass("loading");
				}',
				'success'=>'function(data) {
					if(data.deleted) {
						$(this).closest(".item_container").slideUp();
					}
				}',
				'error'=>'function(jqXHR, textStatus, errorThrown) {
					alert(textStatus + " " + errorThrown);
				}',
				'complete'=>'function(jqXHR, textStatus) {
					$(this).removeClass("loading");
				}'

			),
			// html options
			array(
				'class'=>"edit_mode delete_button"
			)
		);
	};
?>

<script>
	$(document).ready(function(){
		$("#jPlayer_<?php echo $song->id ?>").jPlayer({
			ready: function (event) {
				$(this).jPlayer("setMedia", {
					mp3:"<?php echo $song->songUrl ?>",
				}).jPlayer( "load" );
			},
			play: function() { // To avoid both jPlayers playing together.
				$(this).jPlayer("pauseOthers");
			},
			swfPath: "/muso/js",
			supplied: "mp3",
			cssSelectorAncestor: "#jp_container_<?php echo $song->id ?>",
			wmode: "window"
		});
	});
</script>
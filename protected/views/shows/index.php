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

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/timeline/js/timeline.js", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('12', '$(document).ready(function(){
	window.shows_timeline = {
		tl: new Timeline("timeline"),
		shows_list: {},
		currently_selected_show: undefined
	};
});', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/timeline/css/timeline.css");
?>

<script>
$(document).ready(function(){
	// hide all events from display

	var show_views = $('.shows_list .show_view');
	show_views.each(function() {
		window.shows_timeline.shows_list[$(this).attr('timeline_id')] = $(this);
	});

	window.shows_timeline.hide_all_shows = function() {
		show_views.each(function() {
			$(this).hide();
		});
	}
	window.shows_timeline.hide_all_shows();

	// beware, this is soooo hacky
	window.shows_timeline.tl.bubble.hide = function() {};

	// set click event to show the relevant event, hiding the previous
	busy = false;
	function show_event_event(event) {
		show_event($(event.target));
	}
	function show_event(target) {
		if(busy) {
			return;
		}
		var event_id = target.attr('timeline_event_id');
		if(typeof window.shows_timeline.currently_selected_show !== 'undefined') {
			if(window.shows_timeline.shows_list[event_id].get(0) === window.shows_timeline.currently_selected_show.get(0)) {
				window.shows_timeline.tl.bubble.container.show(); // make sure the arrow is pointing, might have been removed by moving from a month with no events.
				return;
			}
			window.shows_timeline.currently_selected_show.hide();
		}
		window.shows_timeline.currently_selected_show = window.shows_timeline.shows_list[event_id];

		var left  = target.offset().left;
        var width = target.outerWidth();   
        var at = left + (width / 2);

		window.shows_timeline.currently_selected_show.show();
		window.shows_timeline.tl.bubble.container.css({left: at - (window.shows_timeline.tl.bubble.container.outerWidth() / 2)});
		window.shows_timeline.tl.bubble.container.show();
	}

	window.shows_timeline.tl.onMouseEnter = show_event_event; // override the timeline.js one, hacky :(
	window.shows_timeline.tl.onMouseLeave = function() {};

	function on_change_month() {
		//select the first event in the month
		var lowest_day = undefined;
		$('.event').each(function() {
			day = parseInt($(this).text());
			if(isNaN(day)) {
				return;
			}
			if(typeof(lowest_day) === 'undefined' || (day < lowest_day.day)) {
				lowest_day = { day: day, obj: $(this) };
			} 
		})
		if(typeof(lowest_day) === 'undefined') {
			window.shows_timeline.tl.bubble.container.hide();
		} else {
			show_event(lowest_day.obj);
		}
		return lowest_day;
	}

	window.shows_timeline.tl.old_next_month = window.shows_timeline.tl.nextMonth;
	window.shows_timeline.tl.old_previous_month = window.shows_timeline.tl.previousMonth;
	window.shows_timeline.tl.nextMonth = function() {	
		window.shows_timeline.tl.old_next_month();
		return on_change_month();
	};
	window.shows_timeline.tl.previousMonth = function() {	
		window.shows_timeline.tl.old_previous_month();
		return on_change_month();
	};

	if(typeof on_change_month() === 'undefined') {
		var tryMonths = 3;
		while(typeof window.shows_timeline.tl.nextMonth() == 'undefined' && tryMonths > 0) {
			tryMonths--;
		}
	};
});
</script>
<div id="timeline">
    <ul>            
<?php foreach ($shows as $show) { ?>
		<li id="timeline_event_id_<?php echo $show->id ?>" class="<?php echo $show->title ?>" title="<?php echo strftime( "%d %B %Y", strtotime($show->time)) ?>"><?php echo $show->description ?></li>
<?php } ?>
    </ul>            
</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'htmlOptions'=>array('class'=>'shows_list'),
	'summaryText'=>''
)); ?>

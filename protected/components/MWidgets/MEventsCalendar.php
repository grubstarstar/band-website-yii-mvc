<?php

class MEventsCalendar extends CWidget
{
	public $events;

    public function run()
    {
    	$this->events = Event::model()->findAll();

		$this->controller->widget('application.extensions.fullcalendar.FullcalendarGraphWidget', 
	    	array(
	        	'data'=>array(
		                'title'=> 'All Day Event',
		                'start'=> date('Y-m-j')
		        ),
		        'options'=>array(
		            'editable'=>true,
		            'dayClick' => 'js:function(date) {
							alert(date);
		    		}',
		    		'events' => "js:" . $this->getEventJavascriptArray($this->events)
		        ),
		        'htmlOptions'=>array(
		               'style'=>'width:800px;margin: 0 auto;'
		        )
		    )
	    );

	    ;
    }

    private function getEventJavascriptArray($events) {
    	$jsEventObjs;
    	foreach ($events as $event) {
    		$name = $event->event_name;
    		$start = $event->start->format('Y-m-d H:i:s');
    		$end = $event->end->format('Y-m-d H:i:s');

    		$jsEventObjs[] = "\t{\n\t\ttitle: '$name',\n\t\tstart: '$start',\n\t\tend: '$end'\n\t}";
    	}
    	$jsEventObjs = implode(",\n", $jsEventObjs);
    	$jsEventObjs = "[\n" . $jsEventObjs . "\n]";
    	return $jsEventObjs;
    }
}
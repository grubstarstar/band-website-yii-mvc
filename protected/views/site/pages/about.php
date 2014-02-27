<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery.slides.js", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('about_slideshow', '$(function(){
      $("#slides").slidesjs({
        width: 350,
        height: 450,
      	play: {
  	      active: true,
  	        // [boolean] Generate the play and stop buttons.
  	        // You cannot use your own buttons. Sorry.
  	      effect: "slide",
  	        // [string] Can be either "slide" or "fade".
  	      interval: 4000,
  	        // [number] Time spent on each slide in milliseconds.
  	      auto: true,
  	        // [boolean] Start playing the slideshow on load.
  	      swap: true,
  	        // [boolean] show/hide stop and play buttons
  	      pauseOnHover: false,
  	        // [boolean] pause a playing slideshow on hover
  	      restartDelay: 2500
  	        // [number] restart delay on inactive slideshow
  	    }
      });
    });'); 
?>


<?php
	$image_urls = array(
		"images/band_photos/sarah.jpg",
		"images/band_photos/Adrian.jpg",
		"images/band_photos/Julian.jpg",
		"images/band_photos/sarah2.jpg",
		"images/band_photos/ricardo.jpg",
		"images/band_photos/Dave.jpg",
		"images/band_photos/Chelsea.jpg",
		"images/band_photos/Eeshan.jpg"
	);
	shuffle($image_urls);
?>
<div id="slides" style="float: left; width: 350px; height: 450px">
<?php foreach ($image_urls as $image_url) { ?>
    <img src="<?php echo $image_url ?>">
<?php } ?>
</div>

<div style="margin-left: 380px; margin-right: 10px;">
<p>Alone with Tiger is a Melbourne based original soul band. Formed in early 2013, they spent the last year serving up old school soul sounds to captivated audiences around town. This seven piece ensemble is a mash up of talented musical characters, bringing together the wisdom garnered from their past bands including: Sound of the Baskervilles, Ade Ishs Trio, Lieutenant Jam, Slowjaxx & The Kozmik Love Orkestra, MOU Quintet, Greeves and The Promises.</p>

<p>Borrowing the bounce of Motown, the heat of soul and the beat of R&B, these guys note Willy Hutch, Grant Green, Erykah Badu and Mayer Hawthorne amongst their inspiration. Chanteuse Cosmos leads the way with an elastic vocal style that encompasses likenesses to Madelaine Peyroux and Janis Joplin. She is supported by a band redolent of the golden age of soul, a vintage sound with horns punctuating over a solid rhythm section, funky keys and dirty electric wailings.</p>

<p>Throughout the journey of each performance, Alone with Tiger relish surprising the audience with sudden changes of pace and emotion. Whipping the crowd into a dance frenzy via a stream of sunshiny up-tempo numbers, they’ll then deftly pull the carpet out and leave them reeling by launching into a raw heartbreaking ballad, only to be revived again by some monumental funk.</p>

<p>Keep your eyes out for the release their full-length album in early June!</p>
</div>

<?php

class WaveImageMaker {

	private $_mp3_filename;
	private $_width;
    private $_height ;
    private $_foreground;
    private $_background;
    private $_draw_flat;
	private $_detail;
	private $_is_stereo;
	private $_img;

	public function __construct($params) {
		$this->_mp3_filename = 	$params['mp3_filename'];
		$this->_width = 		isset($params['width']) 		? $params['width'] 		: 200;
		$this->_height = 		isset($params['height']) 		? $params['height'] 	: 100;
		$this->_foreground = 	isset($params['foreground']) 	? $params['foreground'] : "#FF0000";
		$this->_background = 	isset($params['background']) 	? $params['background'] : "#FFFFFF";
		$this->_draw_flat = 	isset($params['draw_flat']) 	? $params['draw_flat'] 	: false;
		$this->_detail = 		isset($params['detail']) 		? $params['detail'] 	: 5;
		$this->_is_stereo = 	isset($params['is_stereo']) 	? $params['is_stereo'] 	: false;
		ini_set("max_execution_time", "30000");
	}
	
	public function process() {
		if (isset($this->_mp3_filename)) {

		// array of wavs that need to be processed
		$wavs_to_process = array();
		
		/**
		 * convert mp3 to wav using lame decoder
		 * First, resample the original mp3 using as mono (-m m), 16 bit (-b 16), and 8 KHz (--resample 8)
		 * Secondly, convert that resampled mp3 into a wav
		 * We don't necessarily need high quality audio to produce a waveform, doing this process reduces the WAV
		 * to it's simplest form and makes processing significantly faster
		 */
		preg_match('/(?P<filepart>.+)\.(?P<ext>\w{1,4})$/', $this->_mp3_filename, $m);		 
		 
		if ($this->_is_stereo) {
				// scale right channel down (a scale of 0 does not work)
		  exec("lame {$m['filepart']}.{$m['ext']} --scale-r 0.1 -m m -S -f -b 16 --resample 8 {$m['filepart']}_resampled.{$m['ext']} && lame -S --decode {$m['filepart']}_resampled.{$m['ext']} {$m['filepart']}_l.wav");
				// same as above, left channel
		  exec("lame {$m['filepart']}.{$m['ext']} --scale-l 0.1 -m m -S -f -b 16 --resample 8 {$m['filepart']}_resampled.{$m['ext']} && lame -S --decode {$m['filepart']}_resampled.{$m['ext']} {$m['filepart']}_r.wav");
		  $wavs_to_process[] = "{$m['filepart']}_l.wav";
		  $wavs_to_process[] = "{$m['filepart']}_r.wav";
		} else {
		  exec("lame {$m['filepart']}.{$m['ext']} -m m -S -f -b 16 --resample 8 {$m['filepart']}_resampled.{$m['ext']} && lame -S --decode {$m['filepart']}_resampled.{$m['ext']} {$m['filepart']}.wav");
		  $wavs_to_process[] = "{$m['filepart']}.wav";
		}
		
		// delete temporary files
		unlink("{$m['filepart']}_resampled.{$m['ext']}");

		$this->_img = false;

		// generate foreground color
		list($r, $g, $b) = $this->html2rgb($this->_foreground);
		
		// process each wav individually
		for($wav = 1; $wav <= sizeof($wavs_to_process); $wav++) {
	 
		  $filename = $wavs_to_process[$wav - 1];
		
		  /**
		   * Below as posted by "zvoneM" on
		   * http://forums.devshed.com/php-development-5/reading-16-bit-wav-file-318740.html
		   * as findValues() defined above
		   * Translated from Croation to English - July 11, 2011
		   */
		  $handle = fopen($filename, "r");
		  // wav file header retrieval
		  $heading[] = fread($handle, 4);
		  $heading[] = bin2hex(fread($handle, 4));
		  $heading[] = fread($handle, 4);
		  $heading[] = fread($handle, 4);
		  $heading[] = bin2hex(fread($handle, 4));
		  $heading[] = bin2hex(fread($handle, 2));
		  $heading[] = bin2hex(fread($handle, 2));
		  $heading[] = bin2hex(fread($handle, 4));
		  $heading[] = bin2hex(fread($handle, 4));
		  $heading[] = bin2hex(fread($handle, 2));
		  $heading[] = bin2hex(fread($handle, 2));
		  $heading[] = fread($handle, 4);
		  $heading[] = bin2hex(fread($handle, 4));
		  
		  // wav bitrate 
		  $peek = hexdec(substr($heading[10], 0, 2));
		  $byte = $peek / 8;
		  
		  // checking whether a mono or stereo wav
		  $channel = hexdec(substr($heading[6], 0, 2));
		  
		  $ratio = ($channel == 2 ? 40 : 80);
		  
		  // start putting together the initial canvas
		  // $data_size = (size_of_file - header_bytes_read) / skipped_bytes + 1
		  $data_size = floor((filesize($filename) - 44) / ($ratio + $byte) + 1);
		  $data_point = 0;
		  
		  // now that we have the data_size for a single channel (they both will be the same)
		  // we can initialize our image canvas
		  if (!$this->_img) {
			// create original image width based on amount of detail
					// each waveform to be processed with be $this->_height high, but will be condensed
					// and resized later (if specified)
			$this->_img = imagecreatetruecolor($data_size / $this->_detail, $this->_height * sizeof($wavs_to_process));
			
			// fill background of image
			if ($this->_background == "") {
			  // transparent background specified
			  imagesavealpha($this->_img, true);
			  $transparentColor = imagecolorallocatealpha($this->_img, 0, 0, 0, 127);
			  imagefill($this->_img, 0, 0, $transparentColor);
			} else {
			  list($br, $bg, $bb) = $this->html2rgb($this->_background);
			  imagefilledrectangle($this->_img, 0, 0, (int) ($data_size / $this->_detail), $this->_height * sizeof($wavs_to_process), imagecolorallocate($this->_img, $br, $bg, $bb));
			}
		  }

		  while(!feof($handle) && $data_point < $data_size){
			if ($data_point++ % $this->_detail == 0) {
			  $bytes = array();
			  
			  // get number of bytes depending on bitrate
			  for ($i = 0; $i < $byte; $i++)
				$bytes[$i] = fgetc($handle);
			  
			  switch($byte){
				// get value for 8-bit wav
				case 1:
				  $data = $this->findValues($bytes[0], $bytes[1]);
				  break;
				// get value for 16-bit wav
				case 2:
				  if(ord($bytes[1]) & 128)
					$temp = 0;
				  else
					$temp = 128;
				  $temp = chr((ord($bytes[1]) & 127) + $temp);
				  $data = floor($this->findValues($bytes[0], $temp) / 256);
				  break;
			  }
			  
			  // skip bytes for memory optimization
			  fseek($handle, $ratio, SEEK_CUR);
			  
			  // draw this data point
			  // relative value based on height of image being generated
			  // data values can range between 0 and 255
			  $v = (int) ($data / 255 * $this->_height);
			  			  
			  // don't print flat values on the canvas if not necessary
			  if (!($v / $this->_height == 0.5 && !$this->_draw_flat))
				// draw the line on the image using the $v value and centering it vertically on the canvas
				imageline(
				  $this->_img,
				  // x1
				  (int) ($data_point / $this->_detail),
				  // y1: height of the image minus $v as a percentage of the height for the wave amplitude
				  $this->_height * $wav - $v,
				  // x2
				  (int) ($data_point / $this->_detail),
				  // y2: same as y1, but from the bottom of the image
				  $this->_height * $wav - ($this->_height - $v),
				  imagecolorallocate($this->_img, $r, $g, $b)
				);         
				
			} else {
			  // skip this one due to lack of detail
			  fseek($handle, $ratio + $byte, SEEK_CUR);
			}
		  }
		  
		  // close and cleanup
		  fclose($handle);

		  // delete the processed wav file
		  unlink($filename);
		  
		}
	  
		// want it resized?
		if ($this->_width) {
		  // resample the image to the proportions defined in the form
		  $rimg = imagecreatetruecolor($this->_width, $this->_height);
		  // save alpha from original image
		  imagesavealpha($rimg, true);
		  imagealphablending($rimg, false);
		  // copy to resized
		  imagecopyresampled($rimg, $this->_img, 0, 0, 0, 0, $this->_width, $this->_height, imagesx($this->_img), imagesy($this->_img));
		  $this->_img = $rimg;

		  //imagedestroy($rimg);
		}		
	  } else {
		// error, no file name given
	  }
	}
	
	public function saveAs($filename) {
		$rv = imagepng($this->_img, $filename);
		//imagedestroy($this->_img);
		return $rv;
	}
	
	public function getImageObj() {
		imagepng($this->_img);
		return $this->_img;
	}
		
	/**
	* GENERAL FUNCTIONS
	*/
	private function findValues($byte1, $byte2) {
		$byte1 = hexdec(bin2hex($byte1));                        
		$byte2 = hexdec(bin2hex($byte2));                        
		return ($byte1 + ($byte2*256));
	}

	/**
	* Great function slightly modified as posted by Minux at
	* http://forums.clantemplates.com/showthread.php?t=133805
	*/
	private function html2rgb($input) {
		$input=($input[0]=="#")?substr($input, 1,6):substr($input, 0,6);
		return array(
			hexdec(substr($input, 0, 2)),
			hexdec(substr($input, 2, 2)),
			hexdec(substr($input, 4, 2))
		);
	}  

}
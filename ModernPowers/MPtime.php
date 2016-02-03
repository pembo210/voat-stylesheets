<?php
//creates transparent png of current game time
//game start time = 07/24/2015 0:00

//today
$ttime = gmdate("Y-m-d");

//find business days, 5 days a week, 1 week = 1 MP year
$startDate = "2015-07-24";
$endDate = $ttime;
$workingDays = 0;
 
$startTimestamp = strtotime($startDate);
$endTimestamp = strtotime($endDate);
for($i=$startTimestamp; $i<=$endTimestamp; $i = $i+(60*60*24) ){
	if(date("N",$i) <= 5) $workingDays = $workingDays + 1;
}
$MPyearDiff = floor($workingDays / 5);

// day of the week, check hour for meta
$today = gmdate(l); 
$nowHour = gmdate(H);
$metaHours = array("00", "01", "02");

if($today==Monday){
	$MPmonth = "Jan/Feb";
}
elseif($today==Tuesday){
	$MPmonth = "Mar/Apr";
}
elseif($today==Wednesday){
	$MPmonth = "May/Jun";
}
elseif($today==Thursday){
	$MPmonth = "Jul/Aug";
}
elseif($today==Friday){
	$MPmonth = "Sep/Oct";
}
elseif($today==Saturday){
	$MPmonth = "Nov/Dec";
}
elseif($today==Sunday){
	if (in_array($nowHour, $metaHours)) {
		$MPmonth = "Nov/Dec";
		} else {
		$MPmonth = "Meta";
	}
}

$currentYear = gmdate("Y");
$MPyear = ($MPyearDiff + $currentYear);
$MPnow = $MPmonth .",". $MPyear;

//day/night mode
//website.com/MPtime.php?m=dark
if($_GET["m"]=="dark") {
	$i = new darktextPNG;
	} else {
	$i = new textPNG;
}

$i->msg = $MPnow ; //text to convert

header("Content-type: image/png");
$i->draw();

//night mode, white text
class darktextPNG {
	var $font = 'font/UbuntuMono-RI.ttf'; //font
	//var $msg = "txt"; // old default text //ignore
	var $size = 24; // font size
	var $rot = 0; // rotation
	var $pad = 0; // padding
	var $transparent = 1; // transparency 1 = on
	var $red = 255; // 255, 255, 255 = white text
	var $grn = 255;
	var $blu = 255;
	var $bg_red = 0; // 0,0,0 = black background
	var $bg_grn = 0;
	var $bg_blu = 0;
	
	function draw() {
		$width = 0;
		$height = 0;
		$offset_x = 0;
		$offset_y = 0;
		$bounds = array();
		$image = "";
	
		// get the font height
		$bounds = ImageTTFBBox($this->size, $this->rot, $this->font, "W");
		if ($this->rot < 0) {
			$font_height = abs($bounds[7]-$bounds[1]);		
		} 
		else if ($this->rot > 0) {
		$font_height = abs($bounds[1]-$bounds[7]);
		} else {
			$font_height = abs($bounds[7]-$bounds[1]);
		}

		//bounding box
		$bounds = ImageTTFBBox($this->size, $this->rot, $this->font, $this->msg);
		if ($this->rot < 0) {
			$width = abs($bounds[4]-$bounds[0]);
			$height = abs($bounds[3]-$bounds[7]);
			$offset_y = $font_height;
			$offset_x = 0;
		} 
		else if ($this->rot > 0) {
			$width = abs($bounds[2]-$bounds[6]);
			$height = abs($bounds[1]-$bounds[5]);
			$offset_y = abs($bounds[7]-$bounds[5])+$font_height;
			$offset_x = abs($bounds[0]-$bounds[6]);
		} else {
			$width = abs($bounds[4]-$bounds[6]);
			$height = abs($bounds[7]-$bounds[1]);
			$offset_y = $font_height;;
			$offset_x = 0;
		}
		
		$image = imagecreate($width+($this->pad*2)+1,$height+($this->pad*2)+1);
		$background = ImageColorAllocate($image, $this->bg_red, $this->bg_grn, $this->bg_blu);
		$foreground = ImageColorAllocate($image, $this->red, $this->grn, $this->blu);
	
		if ($this->transparent) ImageColorTransparent($image, $background);
		ImageInterlace($image, false);
	
		// render the image
		ImageTTFText($image, $this->size, $this->rot, $offset_x+$this->pad, $offset_y+$this->pad, $foreground, $this->font, $this->msg);
	
		// output PNG object.
		imagePNG($image);
	}
}

//day mode, black text
class textPNG {
	var $font = 'font/UbuntuMono-RI.ttf'; //font
	//var $msg = "txt"; // old default text //ignore
	var $size = 24; // font size
	var $rot = 0; // rotation
	var $pad = 0; // padding
	var $transparent = 1; // transparency 1 = on
	var $red = 0; // 0,0,0 = black text
	var $grn = 0;
	var $blu = 0;
	var $bg_red = 255; // 255, 255, 255 = white background
	var $bg_grn = 255;
	var $bg_blu = 255;
	
	function draw() {
		$width = 0;
		$height = 0;
		$offset_x = 0;
		$offset_y = 0;
		$bounds = array();
		$image = "";
	
		// get the font height
		$bounds = ImageTTFBBox($this->size, $this->rot, $this->font, "W");
		if ($this->rot < 0) {
			$font_height = abs($bounds[7]-$bounds[1]);		
		} 
		else if ($this->rot > 0) {
		$font_height = abs($bounds[1]-$bounds[7]);
		} else {
			$font_height = abs($bounds[7]-$bounds[1]);
		}

		//bounding box
		$bounds = ImageTTFBBox($this->size, $this->rot, $this->font, $this->msg);
		if ($this->rot < 0) {
			$width = abs($bounds[4]-$bounds[0]);
			$height = abs($bounds[3]-$bounds[7]);
			$offset_y = $font_height;
			$offset_x = 0;
		} 
		else if ($this->rot > 0) {
			$width = abs($bounds[2]-$bounds[6]);
			$height = abs($bounds[1]-$bounds[5]);
			$offset_y = abs($bounds[7]-$bounds[5])+$font_height;
			$offset_x = abs($bounds[0]-$bounds[6]);
		} else {
			$width = abs($bounds[4]-$bounds[6]);
			$height = abs($bounds[7]-$bounds[1]);
			$offset_y = $font_height;;
			$offset_x = 0;
		}
		
		$image = imagecreate($width+($this->pad*2)+1,$height+($this->pad*2)+1);
		$background = ImageColorAllocate($image, $this->bg_red, $this->bg_grn, $this->bg_blu);
		$foreground = ImageColorAllocate($image, $this->red, $this->grn, $this->blu);
	
		if ($this->transparent) ImageColorTransparent($image, $background);
		ImageInterlace($image, false);
	
		// render the image
		ImageTTFText($image, $this->size, $this->rot, $offset_x+$this->pad, $offset_y+$this->pad, $foreground, $this->font, $this->msg);
	
		// output PNG object.
		imagePNG($image);
	}
}

	$text = new textPNG;

	if (isset($msg)) $text->msg = $msg; 	// text
	if (isset($font)) $text->font = $font; 	// font
	if (isset($size)) $text->size = $size; 	// size
	if (isset($rot)) $text->rot = $rot;	// rotation
	if (isset($pad)) $text->pad = $pad;	// padding
	if (isset($red)) $text->red = $red;	// text color
	if (isset($grn)) $text->grn = $grn;	// ..
	if (isset($blu)) $text->blu = $blu;	// ..
	if (isset($bg_red)) $text->bg_red = $bg_red; 	// background color
	if (isset($bg_grn)) $text->bg_grn = $bg_grn; 	// ..
	if (isset($bg_blu)) $text->bg_blu = $bg_blu; 	// ..
	if (isset($tr)) $text->transparent = $tr; 	// transparency flag 

	$text->draw(); //dun
?>

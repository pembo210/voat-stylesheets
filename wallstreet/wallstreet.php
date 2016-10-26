<?php
header("Content-type: image/png");

//if we start getting throttled
//$sleep = '0';
//a:
$posts = @file_get_contents('https://www.google.com/finance/info?q=NSE:AAPL,GOOGL,AMZN,MSFT,NFLX,FB,WMT,GM,WFC,XOM');
//if (strpos($http_response_header[0], "429")) { 
//	sleep(3);$sleep++;
//	if ($sleep > 3) {sleep(10);$sleep = '0';}
//	goto a;
//}

//remove breaks and extra chars
$output = str_replace(array("\r\n", "\r"), "\n", $posts);
$lines = explode("\n", $output);
$new_lines = array();
foreach ($lines as $i => $line) {
    if(!empty($line))
        $new_lines[] = trim($line);
}
$outtmp = implode($new_lines);
$out2 = ltrim($outtmp,"//");
$out = str_replace(' ', '', $out2);


$stocks = json_decode($out, true);
$result = "";
foreach($stocks as $stock) {
	$result .= $stock['t'].' $';      // name
	$result .= $stock['l'].'';        // price
	$result .= '('.$stock['c'].'), '; // $ change
}
//echo $result;

$i = new darkPNG;
$i->msg = $result;
$i->draw();

//night mode, white text with transparency
class darkPNG {
	var $font = 'font/arial.ttf'; // any font .ttf
	var $size = 14; // font size
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

?>

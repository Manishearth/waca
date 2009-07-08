<?php

/**************************************************************
** English Wikipedia Account Request Interface               **
** Wikipedia Account Request Graphic Design by               **
** Charles Melbye is licensed under a Creative               **
** Commons Attribution-Noncommercial-Share Alike             **
** 3.0 United States License. All other code                 **
** released under Public Domain by the ACC                   **
** Development Team.                                         **
**             Developers:                                   **
**  SQL ( http://en.wikipedia.org/User:SQL )                 **
**  Cobi ( http://en.wikipedia.org/User:Cobi )               **
** Cmelbye ( http://en.wikipedia.org/User:cmelbye )          **
**FastLizard4 ( http://en.wikipedia.org/User:FastLizard4 )   **
**Stwalkerster ( http://en.wikipedia.org/User:Stwalkerster ) **
**Soxred93 ( http://en.wikipedia.org/User:Soxred93)          **
**Alexfusco5 ( http://en.wikipedia.org/User:Alexfusco5)      **
**OverlordQ ( http://en.wikipedia.org/wiki/User:OverlordQ )  **
**Prodego    ( http://en.wikipedia.org/wiki/User:Prodego )   **
**FunPika    ( http://en.wikipedia.org/wiki/User:FunPika )   **
**PRom3th3an ( http://en.wikipedia.org/wiki/User:Promethean )**
**Chris G ( http://en.wikipedia.org/wiki/User:Chris_G )      **
**************************************************************/

if ($ACC != "1") {
    header("Location: $tsurl/");
    die();
} //Re-route, if you're a web client.

// TODO: Add more fonts from http://openfontlibrary.org/

class captcha {
	public function doCaptcha () {
		$pwd = $this->generatePasswd(4);
		$this->showImage($pwd,200,60);
	}
	
	public function verifyPasswd ($passwd) {
		if ($passwd==$_SESSION['captcha']) {
			return true;
		} else {
			return false;
		}
	}
	
	private function generatePasswd ($length) {
		$i = 0;
		$passwd = '';
		while ($i < $length) {
    			$passwd .= chr(rand(97, 122));
    			$i++;
		}
		$_SESSION['captcha'] = $passwd;
		return $passwd;
	}
	private function getFonts () {
		$font_path = dirname(__FILE__).'/fonts';
		$fonts = array();
		if ($handle = opendir($font_path)) {
		    while (false !== ($file = readdir($handle))) {
			if (substr(strtolower($file), -4, 4) == '.ttf') {
			    $fonts[] = $font_path . '/' . $file;
			}
		    }
		}
		return $fonts;
	}
	private function showImage ($passwd,$width,$height) {
		header ('Content-type: image/png');
		$img = @imagecreatetruecolor($width,$height) or die('Cannot Initialize new GD image stream');
		// draw the backgroud
		$bg_colour = imagecolorallocate($img, rand(210,255), rand(210,255), rand(210,255));
		imagefilledrectangle($img,0,0,$width,$height,$bg_colour);
		// word out text spacing
		$spacing = $width / (strlen($passwd)+2);
		$x = $spacing;
		// draw the text
		for ($i=0;$i<strlen($passwd);$i++) {
			$letter = $passwd[$i];
			$size = rand($height/3, $height/2);
			$rotation = rand(-30,30);
			$y = rand($height * .90, $height-$size-4);
			$fonts = $fonts[array_rand($fonts)];
			$r = rand(100,255); $g = rand(100,255); $b = rand(100,255);
			$colour = imagecolorallocate($img,$r,$g,$b);
			$shadow = imagecolorallocate($img,$r/3,$g/3,$b/3);
			imagettftext($img,$size,$rotation,$x,$y,$shadow,$font,$letter);
			imagettftext($img,$size,$rotation,$x-1,$y-3,$colour,$font,$letter);
			$x += rand($spacing,$spacing*1.5);
		}
		imagepng($img);
		imagedestroy($img);
	}
}

?>
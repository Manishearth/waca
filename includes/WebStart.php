<?php

if ($ACC != "1") {
	header("Location: $tsurl/");
	die();
} //Re-route, if you're a web client.

/**
 * AutoLoad array - the system will first search for the file it thinks it 
 * should be in, and try loading that, then it will look up this array.
 *
 * TL;DR; - you only need to list a class in this if the name of file in which
 * the class is contained is NOT Classname.php.
 */
$gAutoload = array(
	"Request" => "request.php",
);

class WebStart {
	public static function setup() {
		spl_autoload_register('WebStart::autoload');
	}

	public static autoload($class) {
		if( file_exists( 'includes/' . $class . '.php' ) ) {
			require_once( 'includes/' . $class . '.php' );
		} else {
			if( isset( $gAutoload[ $class ] ) ) {
				require_once( 'includes/' . $gAutoload[$class] );
			} else {
				throw new Exception( "Class not found: $class" );
			}
		}
	}
}
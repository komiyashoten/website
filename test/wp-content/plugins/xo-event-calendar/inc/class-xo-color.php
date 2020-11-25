<?php

class XO_Color {

	public static function getRgb( $colorcode ) {
		$rgb = array( 'r' => 0, 'g' => 0, 'b' => 0 );
		if ( preg_match( '/^#[a-fA-F0-9]{6}$/', $colorcode ) || preg_match( '/^#[a-fA-F0-9]{3}$/', $colorcode ) ) {
			$colorcode = strtr( $colorcode, array( '#' => '' ) );
			$len = ( strlen( $colorcode ) === 6 ) ? 2 : 1;
			$rgb['r'] = hexdec( substr( $colorcode, 0, $len ) );
			$rgb['g'] = hexdec( substr( $colorcode, 1 * $len, $len ) );
			$rgb['b'] = hexdec( substr( $colorcode, 2 * $len, $len ) );
		}
		return $rgb;
	}

	public static function getHsv( $rgb ) {
		$hsv = array( 'h' => 0, 's' => 0, 'v' => 0 );
		$r = $rgb['r'] / 255;
		$g = $rgb['g'] / 255;
		$b = $rgb['b'] / 255;
		$max = max( $r, $g, $b );
		$min = min( $r, $g, $b );
		$hsv['v'] = $max;
		if ( $max === $min ) {
			$hsv['h'] = 0;
		} else if ( $r === $max ) {
			$hsv['h'] = 60 * (($g - $b) / ($max - $min)) + 0;
		} else if ( $g === $max ) {
			$hsv['h'] = 60 * (($b - $r) / ($max - $min)) + 120;
		} else {
			$hsv['h'] = 60 * (($r - $g) / ($max - $min)) + 240;
		}
		if ( $hsv['h'] < 0 )
			$hsv['h'] = $hsv['h'] + 360;
		$hsv['s'] = ($hsv['v'] != 0) ? ($max - $min) / $max : 0;
		return $hsv;
	}

}

<?php

class CPAC_Autoload {

	static $prefixes = array( 'CPAC' );

	public static function load_class( $classname ) {
		$path = str_replace( '_', '/', $classname );
		$prefix = current( explode( '/', $path ) );

		if ( ! in_array( $prefix, self::$prefixes ) ) {
			return false;
		}

		try {
			$class = CPAC_DIR . $path . '.php';

			if ( ! is_file( $class) ) {
				throw new Exception( sprintf( __( 'File %s not found.' ), $classname ) );
			}

			require_once CPAC_DIR . $path . '.php';
		} catch( Exception $e ) {
			return false;
		}
	}
}

spl_autoload_register( 'CPAC_Autoload::load_class' );
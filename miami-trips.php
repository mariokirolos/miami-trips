<?php 
/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */
/**
 *
 *	Plugin Name: Miami Trips Plugin
 *	Version: 1.0
 *	Description: This plugin will control all the trips Miami will create
 *	Author: Mario Kirolos
 *	Author URI: https://mariokirolos.com
 *	Plugin URI: https://mariokirolos.com/plugins/miami-trips
 *	License: GPL2
 */


if(! defined ('ABSPATH')){
	die();
}


if(file_exists( dirname( __FILE__ ) . '/vendor/autoload.php')){
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php');
}


//Register the Activate and deactivate 

function MiamiTripsActivate(){
	MiamiTrips\Base\Activate::activate();
}

function MiamiTripsDeactivate(){
	MiamiTrips\Base\Deactivate::deactivate();
}

//Register the activate Hook
register_activation_hook( __FILE__, 'MiamiTripsActivate' );

//Register the Deactivate Hook
register_deactivation_hook( __FILE__, 'MiamiTripsDeactivate' );


if( class_exists('MiamiTrips\\Init') ){
	MiamiTrips\Init::register_services();
}
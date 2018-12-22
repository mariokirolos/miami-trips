<?php 

/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Base;

 class Deactivate{

 	public static function deactivate(){
 		flush_rewrite_rules();
 	}

 	//Remove the database tables data.
 }
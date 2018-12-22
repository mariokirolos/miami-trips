<?php 

/** 
 *		Trigger this file on Plugin uninstall
 *
 *
 *
 */


if (! defined('WP_UNINSTALL_PLUGIN')){
	die();
}



if(file_exists( dirname( __FILE__ ) . '/vendor/autoload.php')){
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php');
}

Use MiamiTrips\Base\Database;
Use MiamiTrips\Base\BaseController;


$base = new BaseController();
//$option_name = $base->plugin;

//Remove Table
$database = new Database();
$database->removeTable();

//delete_option($option_name);
 
// for site options in Multisite
//delete_site_option($option_name);
 

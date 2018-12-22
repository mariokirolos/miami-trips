<?php 
/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Base;

use \MiamiTrips\Base\BaseController;

 class Enqueue extends BaseController{

 	public function register(){
 		//Register all required js and css for the admin views
		add_action('admin_enqueue_scripts' , array( $this , 'adminEnqueue'));
		//Register all required js and css for the frontend views.
		add_action('wp_enqueue_scripts' , array( $this , 'frontendEnqueue'));
 	}


 	function adminEnqueue(){
		wp_enqueue_media();
		//Bootstrap
		wp_enqueue_style('bootstrap' , $this->plugin_url . 'assets/css/bootstrap.min.css' );
		//Main Admin CSS
		wp_enqueue_style('miamiStyles' , $this->plugin_url . 'assets/css/main.css' );

		//Bootstrap 
		wp_enqueue_script('bootstrap' , $this->plugin_url . 'assets/js/bootstrap.min.js' , __FILE__ );

		//Admin 
		wp_enqueue_script('miami_trips_admin' , $this->plugin_url . 'assets/js/admin.js' , __FILE__ );

	}

	function frontendEnqueue(){
		wp_enqueue_style('AutobodyStyles' , $this->plugin_url . 'assets/css/mainfrontend.css' );
		wp_enqueue_style( 'bootstrap' , 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
		wp_enqueue_style( 'style' , 'https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css');
	
	

		wp_enqueue_script('googleapis' , 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js');
		wp_enqueue_script( 'googleajax'  , 'https://code.jquery.com/ui/1.12.0/jquery-ui.js');
	}

 }
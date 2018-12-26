<?php 

/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Functions;

use MiamiTrips\Base\BaseController;

class TemplateController extends BaseController {


	public $templates;


	public function register(){
		add_filter('single_template', array($this , 'trip_template') , 11);
	}



	function trip_template($single) {

	    global $post;


	    /* Checks for single template by post type */
	    switch( $post->post_type ){
	    	case 'miami_trips':
	    		$url =  $this->plugin_path . 'templates/front-end/trip.php';
	    	break;
	    	// case 'miami_cities':
	    	// break;
	    	// case 'miami_hotels':
	    	// break;
	    	// case 'miami_clients':
	    	// break;
	    	default:
	    	$url = 'single.php';
	    	break;
	    }
	        if ( file_exists($url) ) {
	            return $url;
	        }

	    return $single;

	}
		

}
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
	    $url = 'single.php';
	    switch( $post->post_type ){
	    	case 'miami_trips':
	    		$url =  $this->plugin_url . 'templates/front-end/trip.tpl.php';
	    	break;
	    	// case 'miami_cities':
	    	// break;
	    	// case 'miami_hotels':
	    	// break;
	    	// case 'miami_clients':
	    	// break;
	    }

	        if ( file_exists($url ) ) {
	            return $url;
	        }

	    return $single;

	}
		

}
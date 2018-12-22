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


 class SettingsLinks extends BaseController{

	function register(){
		//Register the Extra links.
		add_filter('plugin_action_links_' . $this->plugin  , array($this , 'extra_links') );

	}

	function extra_links($links){
		//add Extra Links
			//Settings Link
			$settings_link = '<a href="admin.php?page=Autobody">Settings</a>';
			array_push($links , $settings_link);


			return $links;
	}

 }
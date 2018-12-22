<?php 

/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Functions;

class imageUpload{

/**
	The Args contains
	input_name		This is the name that will be saved in the database.
	current_values	This will hold the current values if any in the required container
	btn_text 		This will be the text on the button which will open the media uploader

	media_title 	This will be the title appears on the media uploader
	media_button 	This will be the text on the button in the media uploader
	multiple		This is an option whether the uploader will upload multiple or only 1.


*/



	function uploader($args = null){
		$args['input_name'] = (isset($args['input_name'])) ? $args['input_name'] : 'images' ;
		$args['current_values'] = (isset($args['current_values'])) ? $args['current_values'] : [] ;
		$args['btn_text'] = (isset($args['btn_text'])) ? $args['btn_text'] : 'Upload' ;
		$args['media_title'] = (isset($args['media_title'])) ? $args['media_title'] : 'Choose Images' ;
		$args['media_button'] = (isset($args['media_button'])) ? $args['media_button'] : 'Upload' ;
		$args['multiple'] = (isset($args['multiple'])) ? $args['multiple'] : 'true' ;

		$return =  '<div class="upload col-12">';
			$return .= '<div class="row images">';
					foreach($args['current_values'] as $one){
						$return .=   '<div class="image"><button class="remove">x</button>' .
						'<input type="hidden" name="'. $args['input_name'] .'[]" value="' .  $one . '" />'.
									wp_get_attachment_image($one) .
								'</div>';
					}
			$return .= '</div>';
				$return .='<div class="row">'.
							'<button class="button button-primary button-large uploadBTN" data-btn_text="'. $args['media_button'] .'" data-title="'. $args['media_title'] .'" data-inputname="'. $args['input_name'] .'" data-multiple="'. $args['multiple'] .'" >Upload</button>'.
							'</div>'.
						'</div>';


		return $return;


	}

}


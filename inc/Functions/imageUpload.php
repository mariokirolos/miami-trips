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
	classes 		This will be an extra classes to apply if needed on the Main Uploader BTN

	media_title 	This will be the title appears on the media uploader
	media_button 	This will be the text on the button in the media uploader
	multiple		This is an option whether the uploader will upload multiple or only 1.


*/



	function uploader($args = null){
		$args['input_name'] = (isset($args['input_name'])) ? $args['input_name'] : 'images' ;
		$args['current_values'] = (isset($args['current_values'])) ? $args['current_values'] : [] ;
		$args['btn_text'] = (isset($args['btn_text'])) ? $args['btn_text'] : 'Upload' ;
		$args['classes'] = (isset($args['classes'])) ? $args['classes'] : '' ;



		$args['media_title'] = (isset($args['media_title'])) ? $args['media_title'] : 'Choose Images' ;
		$args['media_button'] = (isset($args['media_button'])) ? $args['media_button'] : 'Upload' ;
		$args['multiple'] = (isset($args['multiple'])) ? $args['multiple'] : 'true' ;

		$return =  '<div class="upload col-12">';
			$return .= '<div class="row images">';
				if(!empty(array_filter($args['current_values']))){
					foreach($args['current_values'] as $one){
						if(!empty($one)){
							$return .=   
						'<input type="hidden" name="'. $args['input_name'] .'[]" value="' .  $one . '" />'.
						'<div class="image"><button class="remove">x</button>' .
						
									wp_get_attachment_image($one) .
								'</div>';
						}
					}
				}
			$return .= '</div>';
				$return .='<div class="row">'.
							'<button class="button button-primary button-large uploadBTN '. $args['classes'] .' " data-btn_text="'. $args['media_button'] .'" data-title="'. $args['media_title'] .'" data-inputname="'. $args['input_name'] .'" data-multiple="'. $args['multiple'] .'" >'. $args['btn_text'] .'</button>'.
							'</div>'.
						'</div>';


		return $return;


	}

}


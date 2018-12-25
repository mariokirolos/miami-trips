<?php 

/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Functions;

class Modal{

	/**
	*
	*	@desc 	This function will return a modal with all it's requirements
	*	@args 	An array of group of settings that the modal needs
	*	
	*	id(string)					Modal Id
	*	aria-labelledby(string)		Label for the modal
	*	header(string)				The header content 
	*	body(string)				The content of the modal body
	*	extrabtns(array)			Every extra button will be an array item which is an array as well
	*	extrabtns[id]				id of the extra button added
	*	extrabtns[classes]			all the classes will be added to this extra btn
	*	extrabtns[text]				The text will be shown in the extra btn
	*
	*/
	function modal($args = null){

		$args['id'] = (isset($args['id'])) ?  $args['id'] :  'modal' ;
		$args['aria-labelledby'] = (isset($args['aria-labelledby'])) ?  $args['aria-labelledby'] :  'modal' ;
		$args['header'] = (isset($args['header'])) ?  $args['header'] :  'Error' ;
		$args['body'] = (isset($args['body'])) ?  $args['body'] :  'Error found, please try again later!' ;

		$return  = '<div class="modal fade" id="'. $args['id'] .'" tabindex="-1" role="dialog" aria-labelledby="'. $args['aria-labelledby'] .'" aria-hidden="true">' .
  '<div class="modal-dialog" role="document">'.
    '<div class="modal-content">'.
      '<div class="modal-header">'.
        '<h5 class="modal-title" >'. $args['header'] .'</h5>'.
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>'.
        '</button>'.
      '</div>'.
      '<div class="modal-body">'.
        $args['body'].
      '</div>'.
      '<div class="modal-footer">'.
        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        if(isset($args['extrabtns'])){
        	foreach($args['extrabtns'] as $extrabtn){
	        	$return .= '<button type="button" id="'. $extrabtn['id'] .'" class="'. $extrabtn['classes'] .'">'. $extrabtn['text'] .'</button>';
	        }
        }
      $return .= '</div>'.
    '</div>'.
  '</div>'.
'</div>';


	return $return;
	}

	/**
	*
	*	@description 	This function will return a one action Modal 
	*
	*
	*/
	// function ErrorModal($args = null){
// 		return '<div class="modal fade" id="ErrorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'.
//   '<div class="modal-dialog" role="document">'.
//     '<div class="modal-content">'.
//       '<div class="modal-header">'.
//         '<h5 class="modal-title" >Error</h5>'.
//         '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'.
//           '<span aria-hidden="true">&times;</span>'.
//         '</button>'.
//       '</div>'.
//       '<div class="modal-body">'.
//         '...'.
//       '</div>'.
//       '<div class="modal-footer">'.
//         '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'.
//       '</div>'.
//     '</div>'.
//   '</div>'.
// '</div>';

// 	}

}


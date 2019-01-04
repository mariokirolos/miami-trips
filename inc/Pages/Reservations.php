<?php 

/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Pages;
use MiamiTrips\Base\BaseController;
use MiamiTrips\Pages\Trips;
use MiamiTrips\Pages\Clients;


class Reservations extends BaseController{

 	public $trips;
 	public $clients;

	function register(){

		//Create the Custom Post Type
		add_action( 'init', array($this , 'register_CPT_Reservations') );
		// Add the extra fields to it
		add_action( 'add_meta_boxes_miami_reservations', array($this , 'reservations_extra_fields') );
		//Saving the extra fields
		add_action( 'save_post_miami_reservations', array($this , 'save_post') ); 
		//Change Post Title Placeholder
		add_filter( 'enter_title_here', array($this , 'change_title_placeholder') );
		
	}

	 

	function register_CPT_Reservations() {
	
		$labels = array(
			'name'               => __( 'Reservations', 'miami-reservations' ),
			'singular_name'      => __( 'Reservation', 'miami-reservations' ),
			'add_new'            => _x( 'Add New Reservation', 'miami-reservations', 'miami-reservations' ),
			'add_new_item'       => __( 'Add New Reservation', 'miami-reservations' ),
			'edit_item'          => __( 'Edit Reservation', 'miami-reservations' ),
			'new_item'           => __( 'New Reservation', 'miami-reservations' ),
			'view_item'          => __( 'View Reservation', 'miami-reservations' ),
			'search_items'       => __( 'Search Reservations', 'miami-reservations' ),
			'not_found'          => __( 'No Reservations found', 'miami-reservations' ),
			'not_found_in_trash' => __( 'No Reservations found in Trash', 'miami-reservations' ),
			'parent_item_colon'  => __( 'Reservation:', 'miami-reservations' ),
			'menu_name'          => __( 'Reservations', 'miami-reservations' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => 'This post type will held all the reservations for Miami Travel to.',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-tickets',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
			),
		);
	
		register_post_type( 'miami_reservations', $args );
	}


	function reservations_extra_fields( ) {
   		global $wp_meta_boxes;
   		add_meta_box('reservation_div', __('Reservation Information'), array($this , 'reservation_information') , 'miami_reservations', 'normal', 'low');
	}


	function reservation_information()
	{
	    global $post;
	    $reservation = get_post_custom($post->ID);

	    $trip = $tripDate = $AmountPaid = $MethodOfPayment = $Client = $ConfirmationNumber = '';
	    
	    //Get All Trips
	    $trips = new Trips();
	    $AllTrips = $trips->getAllTrips();

	    //Get All Clients
	    $clients = new Clients();
	    $AllClients = $clients->getAllClients();



	    $paymentMethod = ['Cash' , 'Credit Card' , 'Check' , 'Debit Card'];



print_r($reservation);


	    if(isset($reservation['reservation_information'])){
		    $reservation = json_decode($reservation['reservation_information'][0]);

		    $country = isset($city->country)?$city->country:'';
		    $city_id = isset($city->city_id)?$city->city_id:'';

	    }
	?>	
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="TripName">Trip</label>
				    <select name="TripName" id="TripName" class="form-control">
				    	<option value="">Choose Trip</option>
				    	<?php 
				    		foreach ($AllTrips as $oneTrip) {
				    			print '<option value="'.  $oneTrip->ID .'">'. $oneTrip->post_title .'</option>';
				    		}
				    	?>
				    </select>
			  	</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
				    <label for="TripDate">Trip Date</label>
				    <select name="TripDate" id="TripDate" class="form-control">
				    	<option value="">Choose Date</option>
				    </select>
			  	</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="AmountPaid">Amount Paid</label>
				    <div class="input-group">
				    	<div class="input-group-prepend">
				    		<div class="input-group-text">$</div>
				    	</div>
				    <input type="text" class="number form-control" name="AmountPaid" id="AmountPaid" placeholder="Amount Paid" value="" >
				    </div>
			  	</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
				    <label for="MethodofPayment">Method of Payment</label>
				    <select name="MethodofPayment" id="MethodofPayment" class="form-control"><option value="">Choose Method of Payment</option>
				    	<?php 
				    		foreach($paymentMethod as $method):
				    			print '<option value="'. $method .'">'. $method .'</option>';
				    		endforeach;
				    	?></select>
			  	</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="ClientName">Client Name</label>
				    <select name="ClientName" id="ClientName" class="form-control">
				    	<option value="">Choose Client</option>
				    	<?php foreach ($AllClients as $oneClient) {
				    		print '<option value="'.  $oneClient->ID .'">'. $oneClient->post_title .'</option>';
				    	} ?>
				    </select>
			  	</div>
			</div>
		</div>

	<?php
	}

	function save_post(){

		 if(empty($_POST)) return; 
    	

    	global $post;


    	$reservation_information = array(
    							'TripName' => $_POST["TripName"] ,
    							'TripDate' => $_POST["TripDate"] ,
    							'AmountPaid' => $_POST["AmountPaid"] ,
    							'MethodofPayment' => $_POST["MethodofPayment"] ,
    							'ClientName' => $_POST["ClientName"] ,
    						);

   		update_post_meta($post->ID, "reservation_information", json_encode($reservation_information));
	}


	function change_title_placeholder($title ){
		 $screen = get_current_screen();
  
	     if  ( 'miami_reservations' == $screen->post_type ) {
	          $title = 'Reservation Confirmation Number';
	     }
	  
	     return $title;
	}
 }
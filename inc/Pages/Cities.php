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
use MiamiTrips\Functions\imageUpload;


 class Cities extends BaseController{

 	public $imageUpload;

	function register(){

		//Create the Custom Post Type
		add_action( 'init', array($this , 'register_CPT_Cities') );
		// Add the extra fields to it
		add_action( 'add_meta_boxes_miami_cities', array($this , 'cities_extra_fields') );
		//Saving the extra fields
		add_action( 'save_post_miami_cities', array($this , 'save_post') ); 

		// //Update the table 
		// add_action('manage_conference_booking_posts_columns' , array( $this , 'set_custom_columns'));

		// //Set the table columns to the custom fields
		// add_action('manage_conference_booking_posts_custom_column' , array( $this , 'set_custom_columns_data') , 10 , 2 );

		// add_filter('manage_edit-conference_booking_sortable_columns' , array($this , 'custom_sortable_columns'));
		
	}

	 

	function register_CPT_Cities() {
	
		$labels = array(
			'name'               => __( 'Cities', 'miami-cities' ),
			'singular_name'      => __( 'City', 'miami-cities' ),
			'add_new'            => _x( 'Add New City', 'miami-cities', 'miami-cities' ),
			'add_new_item'       => __( 'Add New City', 'miami-cities' ),
			'edit_item'          => __( 'Edit City', 'miami-cities' ),
			'new_item'           => __( 'New City', 'miami-cities' ),
			'view_item'          => __( 'View City', 'miami-cities' ),
			'search_items'       => __( 'Search Cities', 'miami-cities' ),
			'not_found'          => __( 'No Cities found', 'miami-cities' ),
			'not_found_in_trash' => __( 'No Cities found in Trash', 'miami-cities' ),
			'parent_item_colon'  => __( 'City:', 'miami-cities' ),
			'menu_name'          => __( 'Cities', 'miami-cities' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => 'This post type will held all the cities that Miami Travel to.',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-location-alt',
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
				'excerpt'
			),
		);
	
		register_post_type( 'miami_cities', $args );
	}


	function cities_extra_fields( ) {
   		global $wp_meta_boxes;
   		add_meta_box('city_div', __('City Information'), array($this , 'city_information') , 'miami_cities', 'normal', 'low');

   		add_meta_box('city_pics', __('City Pictures'), array($this , 'city_pics') , 'miami_cities', 'normal', 'low');
	}


	function city_information()
	{
	    global $post;
	    $city = get_post_custom($post->ID);

	    $city = json_decode($city['city_information'][0]);

	    $country = isset($city->country)?$city->country:'';
	    $city_id = isset($city->city_id)?$city->city_id:'';

	?>	

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="country">Country</label>
					<select name="country" class="form-control" id="country">
						<option value="">Choose Country</option>
						<?php 
							foreach($this->coutryList as $key => $one){
								print '<option value="'. $key .'" ';
								print ($key == $country) ? 'selected' : '' ;
								print '>'. $one .'</option>';
							}
						?>
					</select>
				</div><!-- .form-control -->
			</div><!-- .col-md-6 -->

			<div class="col-md-6">
				<div class="form-group">
					<label for="city_id">City Id</label>
					<input type="text" class="form-control" name="city_id" id="city_id" value="<?php print $city_id;?>" />
					<small id="city_id" class="form-text text-muted">This is the City id that connects the city with the weather app</small>
				</div><!-- .form-control -->
			</div><!-- .col-md-6 -->
		</div><!-- .row -->
	<?php
	}


	function city_pics(){
		global $post;

	    $city = get_post_custom($post->ID);

	    $city = json_decode($city['city_information'][0]);

	    $city_images = isset($city->city_images)?$city->city_images:[];


	    $this->imageUpload = new imageUpload();

	    	$args = array(
	    		'input_name' 		=> 'city_images' , 
	    		'current_values'	=> $city_images , 
	    	);


	    print $this->imageUpload->uploader($args);

	}


	function save_post(){

		 if(empty($_POST)) return; 
    	global $post;


    	$city_information = array(
    							'country' => $_POST["country"] ,
    							'city_id' => $_POST["city_id"] ,
    							'city_images' => $_POST["city_images"] ,

    						);



   		update_post_meta($post->ID, "city_information", json_encode($city_information));
	}


	public function set_custom_columns($columns){

		$title = $columns['title'];
		$date = $columns['date'];
		$conference = $columns['taxonomy-conferences'];

		unset($columns['title'] , $columns['date'] , $columns['taxonomy-conferences']);




		$columns['name'] = 'Names' ;
		$columns['paid'] = 'Amount Paid';
		$columns['remaining'] = 'Amount Left';
		$columns['room_type'] = 'Room Type';
		$columns['date'] = $date;






		return $columns;
	}


	public function set_custom_columns_data($column , $postid ){

		$custom = get_post_custom($postid);
	    $number_ad = isset($custom["no_of_adults"][0])?$custom["no_of_adults"][0]:'';
	    $number_ch = isset($custom["no_of_childs"][0])?$custom["no_of_childs"][0]:'';
	    $bt_0_4 = isset($custom["age_between_0_and_4"][0])?$custom["age_between_0_and_4"][0]:'';
	    $bt_5_11 = isset($custom["age_between_5_and_11"][0])?$custom["age_between_5_and_11"][0]:'';
	    $Young_youth = isset($custom["Young_youth"][0])?$custom["Young_youth"][0]:'';
	    $ch_grades = isset($custom["ch_grades"][0])?$custom["ch_grades"][0]:'';
	    $paid = isset($custom["paid"][0])?$custom["paid"][0]:'';
	    $remaining = isset($custom["remaining"][0])?$custom["remaining"][0]:'';
	    

	    $payment_method = isset($custom["payment_method"][0])?unserialize($custom["payment_method"][0]):'';
		$check_numbers = isset($custom["check_numbers"][0])?unserialize($custom["check_numbers"][0]):'';
	    $payment_amount = isset($custom["payment_amount"][0])?unserialize($custom["payment_amount"][0]):'';
	    $payment_date = isset($custom["payment_date"][0])?unserialize($custom["payment_date"][0]):'';
	    

	    $room_numbers  = isset($custom["room_numbers"][0])?$custom["room_numbers"][0]:'';
	    $hotelComments = isset($custom["hotelComments"][0])?$custom["hotelComments"][0]:'';
		$extraComments = isset($custom["extraComments"][0])?$custom["extraComments"][0]:'';
		$roomtype = isset($custom["room_type"][0])?$custom["room_type"][0]:'';

		switch($column){
			case 'name':
			$hotelComments = (!empty($hotelComments))? $hotelComments :'<i>No Additional Comments</i>';

			if(current_user_can('edit_post' , $postid ))
				echo edit_post_link(get_the_title() , '<strong>' , '</strong>') .'<br />'. $hotelComments;
			else
				echo '<strong>' . get_the_title() .'</strong>'  .'<br />'. $hotelComments;

				
			break;
			case 'paid':
				echo $paid;
			break;
			case 'remaining':
				echo $remaining;
			break;
			case 'room_type':
				echo $roomtype;
			break;
		}
	}

	public function custom_sortable_columns($columns){
		$columns['paid'] = 'paid';
		$columns['remaining'] = 'remaining';
		$columns['room_type'] = 'room_type';


		return $columns;
	}

	public function getConferenceBookings($confid){
		$posts_array = get_posts(
		    array(
		        'posts_per_page' => -1,
		        'post_type' => 'conference_booking',
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'conferences',
		                'field' => 'term_id',
		                'terms' => $confid,
		            )
		        )
		    )
		);


		$totalPaid = 0;
		$totalRemaining = 0;

		foreach($posts_array as $key => $post){
			$custom = get_post_custom($post->ID);

			$posts_array[$key]->{'paid'} = $custom['paid'][0];
			$posts_array[$key]->{'remaining'} = $custom['remaining'][0];
			$totalPaid +=  $custom['paid'][0];
			$totalRemaining += $custom['remaining'][0];
		}


		$posts_array['totalPaid'] = $totalPaid;
		$posts_array['totalRemaining'] = $totalRemaining;


		 return $posts_array;
	}


 }
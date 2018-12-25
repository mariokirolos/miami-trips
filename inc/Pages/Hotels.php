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
use MiamiTrips\Pages\Cities;
use MiamiTrips\Functions\Modal;


 class Hotels extends BaseController{

 	public $imageUpload;
 	public $cities;
 	public $modal;

	function register(){

		//Create the Custom Post Type
		add_action( 'init', array($this , 'register_CPT_Hotels') );
		// Add the extra fields to it
		add_action( 'add_meta_boxes_miami_hotels', array($this , 'hotels_extra_fields') );
		//Saving the extra fields
		add_action( 'save_post_miami_hotels', array($this , 'save_post') ); 
	}

	 

	function register_CPT_Hotels() {
	
		$labels = array(
			'name'               => __( 'Hotels', 'miami-hotels' ),
			'singular_name'      => __( 'Hotel', 'miami-hotels' ),
			'add_new'            => _x( 'Add New Hotel', 'miami-hotels', 'miami-hotels' ),
			'add_new_item'       => __( 'Add New Hotel', 'miami-hotels' ),
			'edit_item'          => __( 'Edit Hotel', 'miami-hotels' ),
			'new_item'           => __( 'New Hotel', 'miami-hotels' ),
			'view_item'          => __( 'View Hotel', 'miami-hotels' ),
			'search_items'       => __( 'Search Hotels', 'miami-hotels' ),
			'not_found'          => __( 'No Hotels found', 'miami-hotels' ),
			'not_found_in_trash' => __( 'No Hotels found in Trash', 'miami-hotels' ),
			'parent_item_colon'  => __( 'Hotel:', 'miami-hotels' ),
			'menu_name'          => __( 'Hotels', 'miami-hotels' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => 'This post type will held all the hotels that Miami Travel will use.',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-building',
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
				'excerpt',
				'thumbnail'
			),
		);
	
		register_post_type( 'miami_hotels', $args );
	}


	function hotels_extra_fields( ) {
   		global $wp_meta_boxes;
   		add_meta_box('hotel_div', __('Hotel Information'), array($this , 'hotel_information') , 'miami_hotels', 'normal', 'low');

   		add_meta_box('hotel_pics', __('Hotel Pictures'), array($this , 'hotel_pics') , 'miami_hotels', 'normal', 'low');
	}


	function hotel_information()
	{
	    global $post;
	    $hotel = get_post_custom($post->ID);
	    $city_id = '';

	    //Get All Cities
	    $this->cities = new Cities();
	    $allCities = $this->cities->getCities();

	    //Update the CPT to be in one field
	    if (isset($hotel['hotel_information'])){
		    $hotel = json_decode($hotel['hotel_information'][0]);
		    $city_id = isset($hotel->city_id)?$hotel->city_id:'';
		}
	?>	

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="city_id">City</label>
					<select name="city_id" class="form-control" id="city_id">
						<option value="">Choose City</option>
						<?php 
							foreach($allCities as $one){

								print '<option value="'. $one->ID .'" ';
								print ($one->ID  == $city_id) ? 'selected' : '' ;
								print '>'. $one->post_title  .'</option>';
							}
						?>
					</select>
				</div><!-- .form-control -->
			</div><!-- .col-md-6 -->
		</div><!-- .row -->
	<?php
	}


	function hotel_pics(){
		global $post;

	    $hotel = get_post_custom($post->ID);
	    $hotel_images = [];

	    if (isset($hotel['hotel_information'])){
	    	$hotel = json_decode($hotel['hotel_information'][0]);

		    $hotel_images = isset($hotel->hotel_images)?$hotel->hotel_images:[];

	    }

	    $this->imageUpload = new imageUpload();

	    	$args = array(
	    		'input_name' 		=> 'hotel_images' , 
	    		'current_values'	=> $hotel_images , 
	    	);


	    print $this->imageUpload->uploader($args);


	    $this->modal = new Modal();

			$errorModal = array(
				'id'	=> 'ErrorModal' , 
				'aria-labelledby'	=> 'confirm' , 
				'header'	=> 'Error' , 
				'body'	=> '...' , 
			);

			$confirmModal = array(
				'id'	=> 'confirmModal' , 
				'aria-labelledby'	=> 'error' , 
				'header'	=> 'Confirm Deletion' , 
				'body'	=> 'Are you sure you want to remove this night?' , 
				'extrabtns' => array(
					array(
						'id' => 'ConfirmRemoveBTN' , 
						'classes' => 'btn btn-danger' , 
						'text' => 'Remove'
					),
				)
			);
			print $this->modal->modal($errorModal) . $this->modal->modal($confirmModal);

	}


	function save_post(){

		 if(empty($_POST)) return; 
    	global $post;


    	$hotel_information = array(
    							'city_id' => $_POST["city_id"] ,
    							'hotel_images' => $_POST["hotel_images"] ,

    						);



   		update_post_meta($post->ID, "hotel_information", json_encode($hotel_information));
	}


	function getHotels(){
		return get_posts(array(
			'post_type' => 'miami_hotels'
		) );
	}

 }
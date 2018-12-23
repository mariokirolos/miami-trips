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

	    $country = $city_id = '';


	    if(isset($city['city_information'])){
		    $city = json_decode($city['city_information'][0]);

		    $country = isset($city->country)?$city->country:'';
		    $city_id = isset($city->city_id)?$city->city_id:'';

	    }
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

	    $city_images = [];

	    if(isset($city['city_information'])){
		
			$city = json_decode($city['city_information'][0]);

		    $city_images = isset($city->city_images)?$city->city_images:[];

	    }

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


	function getCities(){
		return get_posts( array(
			'post_type' => 'miami_cities'
		) );
	}


 }
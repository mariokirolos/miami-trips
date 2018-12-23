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

 class Clients extends BaseController{

 	public $imageUpload;
 	public $cities;

	function register(){

		//Create the Custom Post Type
		add_action( 'init', array($this , 'register_CPT_Clients') );
		// Add the extra fields to it
		add_action( 'add_meta_boxes_miami_clients', array($this , 'clients_extra_fields') );
		//Saving the extra fields
		add_action( 'save_post_miami_clients', array($this , 'save_post') ); 
	}

	 

	function register_CPT_Clients() {
	
		$labels = array(
			'name'               => __( 'Clients', 'miami-clients' ),
			'singular_name'      => __( 'Client', 'miami-clients' ),
			'add_new'            => _x( 'Add New Client', 'miami-clients', 'miami-clients' ),
			'add_new_item'       => __( 'Add New Client', 'miami-clients' ),
			'edit_item'          => __( 'Edit Client', 'miami-clients' ),
			'new_item'           => __( 'New Client', 'miami-clients' ),
			'view_item'          => __( 'View Client', 'miami-clients' ),
			'search_items'       => __( 'Search Clients', 'miami-clients' ),
			'not_found'          => __( 'No Clients found', 'miami-clients' ),
			'not_found_in_trash' => __( 'No Clients found in Trash', 'miami-clients' ),
			'parent_item_colon'  => __( 'Client:', 'miami-clients' ),
			'menu_name'          => __( 'Clients', 'miami-clients' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => 'This post type will held all the clients that Miami Travel will serve.',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-groups',
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
	
		register_post_type( 'miami_clients', $args );
	}


	function clients_extra_fields( ) {
   		global $wp_meta_boxes;
   		//Client Information
   		add_meta_box('client_div', __('Client Information'), array($this , 'client_information') , 'miami_clients', 'normal', 'low');
   		//Client Address
   		add_meta_box('client_address_div', __('Client Address'), array($this , 'client_address') , 'miami_clients', 'normal', 'low');
	}


	function client_information()
	{
	    global $post;
	    $client = get_post_custom($post->ID);


	    $title = $suffix = $gender = $dob = $phone = $mobile = $email = '';

	    //Update the CPT to be in one field
	    if (isset($client['client_information'])){
		    $client = json_decode($client['client_information'][0]);
		    $title = $client->title;
		    $suffix = $client->suffix;
		    $gender = $client->gender;
		    $dob = $client->dob;
		    $phone = $client->phone;
		    $mobile = $client->mobile;
		    $email = $client->email;
		}


		$titleList = array('Bishop' , 'Brother' , 'Capt.' , 'Col.' , 'Deacon' , 'Dr.' , 'Father' , 'Lady' , 'Lord' , 'Miss' , 'Monsignor' , 'Mr.' , 'Mrs.' , 'Ms.' , 'Mstr.' , 'Pastor' , 'Rabbi' , 'Rev.' , 'Sister' , 'Sir');

		$suffixList = array('II' , 'III' , 'Jr' , 'Sr');

		$genderList = array('Male' , 'Female' , 'Prefer not to specify');

	?>	

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="title">Title</label>
				    <select name="title" id="title" class="form-control">
				    	<option value="">Choose Title</option>
				    	<?php 
				    		foreach($titleList as $titleItem){
				    			print '<option value="'. $titleItem .'" ';
				    				print ($titleItem == $title) ? ' selected ': '' ;
				    			print '>'. $titleItem .'</option>';
				    		}
				    	?>
				    </select>
				  </div><!-- .form-group -->
			</div><!-- .col-md-6 -->
			<div class="col-md-6">
				<div class="form-group">
				    <label for="suffix">Suffix</label>
				    <select name="suffix" id="suffix" class="form-control">
				    	<option value="">Choose Suffix</option>
				    	<?php 
				    		foreach($suffixList as $suffixItem){
				    			print '<option value="'. $suffixItem .'" ';
				    				print ($suffixItem == $suffix) ? ' selected ': '' ;
				    			print '>'. $suffixItem .'</option>';
				    		}
				    	?>
				    </select>
				  </div><!-- .form-group -->
			</div><!-- .col-md-6 -->
		</div><!-- .row -->

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="gender">Gender</label>
				    <select name="gender" id="gender" class="form-control">
				    	<option value="">Choose Gender</option>
				    	<?php 
				    		foreach($genderList as $genderItem){
				    			print '<option value="'. $genderItem .'" ';
				    				print ($genderItem == $gender) ? ' selected ': '' ;
				    			print '>'. $genderItem .'</option>';
				    		}
				    	?>
				    </select>
				  </div><!-- .form-group -->
			</div><!-- .col-md-6 -->
			<div class="col-md-6">
				<div class="form-group">
				    <label for="dob">Date of Birth</label>
				    <input type="text" id="dob" name="dob" value="<?php print $dob; ?>" class="datepicker form-control"  autocomplete="off" />
				  </div><!-- .form-group -->
			</div><!-- .col-md-6 -->
		</div><!-- .row -->

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="phone">Phone</label>
				    <input type="text" id="phone" name="phone" value="<?php print $phone; ?>" class="number form-control"  />
				  </div><!-- .form-group -->
			</div>
			<div class="col-md-6">
				<div class="form-group">
				    <label for="mobile">Mobile</label>
				    <input type="text" id="mobile" name="mobile" value="<?php print $mobile; ?>" class="number form-control"  />
				  </div><!-- .form-group -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    <label for="email">Email</label>
				    <input type="text" id="email" name="email" value="<?php print $email; ?>" class="email form-control"  />
				  </div><!-- .form-group -->
			</div>
		</div>
	<?php
	}

	function client_address(){
		 global $post;
	    $client = get_post_custom($post->ID);


	    $add1 = $add2 = $city = $state = $zipcode = $country =  '';


	    $this->cities = new Cities();
	    $cityList = $this->cities->getCities();


	    //Update the CPT to be in one field
	    if (isset($client['client_information'])){
		    $client = json_decode($client['client_information'][0]);
		    $add1 = $client->add1;
		    $add2 = $client->add2;
		    $city = $client->city;
		    $state = $client->state;
		    $zipcode = $client->zipcode;
		    $country = $client->country;
		}

		?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					    <label for="add1">Address 1</label>
					    <input type="text" id="add1" name="add1" value="<?php print $add1; ?>" class="form-control"  />
				  </div><!-- .form-group -->
				</div>
				<div class="col-md-6">
					<div class="form-group">
					    <label for="add2">Address 2</label>
					    <input type="text" id="add2" name="add2" value="<?php print $add2; ?>" class="form-control"  />
				  </div><!-- .form-group -->
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
				    <label for="city">City</label>
				    <select name="city" id="city" class="form-control">
				    	<option value="">Choose City</option>
				    	<?php 
				    		foreach($cityList as $cityItem){
				    			print '<option value="'. $cityItem->ID .'" ';
				    				print ($cityItem->ID == $city) ? ' selected ': '' ;
				    			print '>'. $cityItem->post_title .'</option>';
				    		}
				    	?>
				    </select>
				  </div><!-- .form-group -->
				</div>
				<div class="col-md-6">
					<div class="form-group">
					    <label for="state">State <i>(If Needed)</i></label>
					    <input type="text" id="state" name="state" value="<?php print $state; ?>" class="form-control"  />
				  </div><!-- .form-group -->
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					    <label for="zipcode">Zipcode <i>(If Needed)</i></label>
					    <input type="text" id="zipcode" name="zipcode" value="<?php print $zipcode; ?>" class="form-control"  />
				  </div><!-- .form-group -->
				</div>
				<div class="col-md-6">
					<label for="country">Country</label>
					<select name="country" id="country" class="form-control">
				    	<option value="">Choose Country</option>
				    	<?php 
				    		foreach($this->coutryList as $key => $countryItem){
				    			print '<option value="'. $key .'" ';
				    				print ($key == $country) ? ' selected ': '' ;
				    			print '>'. $countryItem .'</option>';
				    		}
				    	?>
				    </select>
				</div>
			</div>
		<?php
	}

	function save_post(){

		 if(empty($_POST)) return; 
    	global $post;


    	$client_information = array(
    							'title' => $_POST["title"] ,
    							'suffix'=> $_POST['suffix'],
    							'gender'=> $_POST['gender'],
    							'dob'=> $_POST['dob'],
    							'phone'=> $_POST['phone'],
    							'mobile'=> $_POST['mobile'],
    							'email'=> $_POST['email'],
    							'add1'=> $_POST['add1'],
    							'add2'=> $_POST['add2'],
    							'city'=> $_POST['city'],
    							'state'=> $_POST['state'],
    							'zipcode'=> $_POST['zipcode'],
    							'country'=> $_POST['country'],
    						);

   		update_post_meta($post->ID, "client_information", json_encode($client_information));
	}


 }
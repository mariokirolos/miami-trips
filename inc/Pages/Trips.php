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
use MiamiTrips\Functions\Modal;
use MiamiTrips\Pages\Hotels;



 class Trips extends BaseController{

 	public $imageUpload;
 	public $modal;
 	public $hotels;

	function register(){

		//Create the Custom Post Type
		add_action( 'init', array($this , 'register_CPT_Trips') );
		// Add the extra fields to it
		add_action( 'add_meta_boxes_miami_trips', array($this , 'trips_extra_fields') );
		//Saving the extra fields
		add_action( 'save_post_miami_trips', array($this , 'save_post') ); 
		
	}

	 

	function register_CPT_Trips() {
	
		$labels = array(
			'name'               => __( 'Trips', 'miami-trips' ),
			'singular_name'      => __( 'Trip', 'miami-trips' ),
			'add_new'            => _x( 'Add New Trip', 'miami-trips', 'miami-trips' ),
			'add_new_item'       => __( 'Add New Trip', 'miami-trips' ),
			'edit_item'          => __( 'Edit Trip', 'miami-trips' ),
			'new_item'           => __( 'New Trip', 'miami-trips' ),
			'view_item'          => __( 'View Trip', 'miami-trips' ),
			'search_items'       => __( 'Search Trips', 'miami-trips' ),
			'not_found'          => __( 'No Trips found', 'miami-trips' ),
			'not_found_in_trash' => __( 'No Trips found in Trash', 'miami-trips' ),
			'parent_item_colon'  => __( 'Trip:', 'miami-trips' ),
			'menu_name'          => __( 'Trips', 'miami-trips' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => 'This post type will have all the trips that Miami will create',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-palmtree',
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
				'excerpt' ,
				'thumbnail'
			),
		);
	
		register_post_type( 'miami_trips', $args );
		flush_rewrite_rules();
	}


	function trips_extra_fields( ) {
   		global $wp_meta_boxes;
   		add_meta_box('trip_div', __('Trip Itinerary'), array($this , 'trip_itinerary') , 'miami_trips', 'normal', 'low');

   		add_meta_box('trip_dates', __('Trip Dates'), array($this , 'trip_dates') , 'miami_trips', 'normal', 'low');

   		add_meta_box('trip_information', __('Trip Information'), array($this , 'trip_information') , 'miami_trips', 'normal', 'low');

   		add_meta_box('trip_optionals', __('Trip Optionals'), array($this , 'trip_optionals') , 'miami_trips', 'normal', 'low');
	}


	function trip_itinerary()
	{
	    global $post;
	    $trip = get_post_custom($post->ID);

	    $night = $day_title = $hotel = $day_image = '';

	    $this->imageUpload = new imageUpload();
	    $this->hotels = new Hotels();



	    $meals = ['Breakfast' , 'Lunch' , 'Dinner'];

	    

	    if(empty($trip)):



	?>	
		<div class="row">
			<div class="col-12">
				<button id="addNightBTN" class="button button-primary">Add Night</button>
				<div class="float-right"><h1 id="no_of_nights">1 Night</h1></div>
			</div>
		</div>
		<div class="row">
			<div class="nights col-12">
				<div class="night row">
					<div class="col-md-9">
						<textarea name="itinerary[]" cols="30" rows="15" class="form-control" placeholder="Day Itinerary"></textarea>
					</div>
					<div class="col-md-3">
						<div class="day_image">
							<?php 

							$uploaderArr = [
								'input_name' => 'day_image' , 
								'btn_text' => 'Set Day Image' ,
								'classes' => 'btn-block', 
								'media_title' => 'Day Image' , 
								'media_button' => 'Set Day Image' , 
								'multiple' => 'false' , 
							];

							echo  $this->imageUpload->uploader($uploaderArr);?>
							<br/>
						</div>
						<div class="day_title">
								<input type="text"  name="day_title[]" class="form-control" placeholder="Day Title">
						</div>
						<div class="meals">
							<?php 
							foreach($meals as $meal){
								print '<input type="checkbox"  name="meals[0][]" value="'. $meal .'" />' . $meal .'<br />';
							}
							?>
						</div>
						<div class="hotel">
							<select name="hotel[]" class="form-control">
								<option value="">Choose Hotel</option>
								<?php 
									foreach($this->hotels->getHotels() as $hotel ){
										print '<option value="'. $hotel->ID .'">'. $hotel->post_title .'</option>';
									}
								?>
							</select>
						</div>
						<div class="remvoe"><button class="btn btn-block btn-danger removeDay" data-toggle="modal" >Remove</button></div>
					</div>
				</div>
			</div>
		</div>
	<?php

		else:
			//if Trip is Found before


			//Set all the Variables
			
			if(isset($trip['trip_information'])){
		
				$trip = json_decode($trip['trip_information'][0] , true);

			    // $itinerary = isset($trip->itinerary)?$trip->itinerary:[];
			    // $day_image = isset($trip->day_image)?$trip->day_image:[];
			    // $day_title = isset($trip->day_title)?$trip->day_title:[];
			    // $db_meals = isset($trip->meals)?$trip->meals:[];
			    // $db_hotel = isset($trip->hotel)?$trip->hotel:[];
			    $itinerary = isset($trip['itinerary'])?$trip['itinerary']:[];
			    $day_image = isset($trip['day_image'])?$trip['day_image']:[];
			    $day_title = isset($trip['day_title'])?$trip['day_title']:[];
			    $db_meals = isset($trip['meals'])?$trip['meals']:[];
			    $db_hotel = isset($trip['hotel'])?$trip['hotel']:[];
?>

		<div class="row">
			<div class="col-12">
				<button id="addNightBTN" class="button button-primary">Add Night</button>
				<div class="float-right"><h1 id="no_of_nights">1 Night</h1></div>
			</div>
		</div>


<?php 
				$count = 0 ;

			    //Loop through the variables
			    foreach($itinerary as $key => $one){
?>
		<div class="row">
			<div class="nights col-12">
				<div class="night row">
					<div class="col-md-9">
						<textarea name="itinerary[]" cols="30" rows="15" class="form-control" placeholder="Day Itinerary"><?php print $itinerary[$key]; ?></textarea>
					</div>
					<div class="col-md-3">
						<div class="day_image">
							<?php 
									$the_day_image = (isset($day_image[$key])) ? $day_image[$key] :'' ; 
							$uploaderArr = [
								'input_name' => 'day_image' , 
								'btn_text' => 'Set Day Image' ,
								'classes' => 'btn-block', 
								'media_title' => 'Day Image' , 
								'media_button' => 'Set Day Image' , 
								'multiple' => 'false' , 
								'current_values' => array($the_day_image)
							];

							echo  $this->imageUpload->uploader($uploaderArr);?>
							<br/>
						</div>
						<div class="day_title">
								<input type="text"  name="day_title[]" class="form-control" placeholder="Day Title" value="<?php print $day_title[$key]; ?>">
						</div>
						<div class="meals">
							<?php 
							foreach($meals as $meal){
								print '<input type="checkbox"  name="meals['. $count .'][]" value="'. $meal .'" ';
									print ( isset($db_meals[$key]) && in_array($meal , $db_meals[$key]) )  ? ' checked ' : '' ;
								print '/>' . $meal .'<br />';
							}
							?>
						</div>
						<div class="hotel">
							<select name="hotel[]" class="form-control">
								<option value="">Choose Hotel</option>
								<?php 
									foreach($this->hotels->getHotels() as $hotel ){
										print '<option value="'. $hotel->ID .'" ';
											print ($hotel->ID  == $db_hotel[$key]) ? ' selected ' : '' ;
										print '>'. $hotel->post_title .'</option>';
									}
								?>
							</select>
						</div>
						<div class="remvoe"><button class="btn btn-block btn-danger removeDay" data-toggle="modal" >Remove</button></div>
					</div>
				</div>
			</div>
		</div>

<?php 	

				$count++;
			    }


		    }

		endif;//End trip is found
	}

	function trip_dates(){

		global $post;
	    $trip = get_post_custom($post->ID);

	     $date_from = $price = $rooms = '';
	     $totalDates = 0 ; 

	     if(isset($trip['trip_information'])){
			//Edit Trip
			$tripDecoded = json_decode($trip['trip_information'][0]);
			$date_from = isset($tripDecoded->date_from)?$tripDecoded->date_from:[];
			$totalDates = (count($date_from) == 1)? 0 : count($date_from);
		}



		?>
		<div class="row">
			<div class="col-12">
				<button id="addDateBTN" class="button button-primary">Add Date</button>
				<div class="float-right"><h1 id="no_of_dates">Repeated <?php print $totalDates; ?> times</h1></div>
			</div>
		</div>


		<div class="dates">
		<?php
		if(isset($trip['trip_information'])){
			//Edit Trip
			$trip = json_decode($trip['trip_information'][0]);
			$date_from = isset($trip->date_from)?$trip->date_from:[];
		    $price_sgl = isset($trip->price_sgl)?$trip->price_sgl:[];
			$price_dbl = isset($trip->price_dbl)?$trip->price_dbl:[];
			$no_of_rooms = isset($trip->no_of_rooms)?$trip->no_of_rooms:[];



			foreach($date_from as $key => $one){
?>

			
				<div class="row date">
					<div class="col-md-3"><input type="text" class="form-control datepicker" name="date_from[]" autocomplete="off" placeholder="Date From" value="<?php print $date_from[$key]; ?>"></div>
					<div class="col-md-4">

						<div class="input-group">
					        <div class="input-group-prepend">
					          <div class="input-group-text">$</div>
					        </div>
					        <input type="text" class="form-control number" name="price_sgl[]" placeholder="Price SGL" value="<?php print $price_sgl[$key]; ?>">
					        <input type="text" class="form-control number" name="price_dbl[]" placeholder="Price DBL" value="<?php print $price_dbl[$key]; ?>">
				      </div>
	
					</div>
					<div class="col-md-3">
						<input type="text" name="no_of_rooms[]" class="form-control number" placeholder="Number of Rooms" value="<?php print $no_of_rooms[$key]; ?>">
					</div>
					<div class="col-md-2"><button class="btn btn-danger btn-block removeDate">Remove</button></div>
				</div>

<?php 
			}

		}else{
			//New Trip
			?>
				<div class="row date">
					<div class="col-md-3"><input type="text" class="form-control datepicker" name="date_from[]" autocomplete="off" placeholder="Date From"></div>
					<div class="col-md-4">

						<div class="input-group">
					        <div class="input-group-prepend">
					          <div class="input-group-text">$</div>
					        </div>
					        <input type="text" class="form-control number" name="price_sgl[]" placeholder="Price SGL">
					        <input type="text" class="form-control number" name="price_dbl[]" placeholder="Price DBL">
				      </div>
	
					</div>
					<div class="col-md-3">
						<input type="text" name="no_of_rooms[]" class="form-control number" placeholder="Number of Rooms">
					</div>
					<div class="col-md-2"><button class="btn btn-danger btn-block removeDate">Remove</button></div>
				</div>
			<?php
		}//New Trip
		?>

		</div><!-- .dates -->
		<?php



	}

	function trip_information(){
		$includes = $excludes = $activityLevel = $generalNotes = '';

		global $post;
	    $trip = get_post_custom($post->ID);
		if(isset($trip['trip_information'])){
			//Edit Trip
			$trip = json_decode($trip['trip_information'][0]);
			$includes = isset($trip->includes)?$trip->includes:'';
			$excludes = isset($trip->excludes)?$trip->excludes:'';
			$generalNotes = isset($trip->generalNotes)?$trip->generalNotes:'';
			$activityLevel = isset($trip->activityLevel)?$trip->activityLevel:'';
		}

		?>
		<div class="row">
			<div class="col-md-6">
				<textarea name="includes" cols="30" rows="10" class="form-control" placeholder="Trip Includes"><?php print $includes;?></textarea>
			</div>
			<div class="col-md-6">
				<textarea name="excludes" cols="30" rows="10" class="form-control" placeholder="Trip Excludes"><?php print $excludes;?></textarea>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-6">
				<div class="form-group">
					<label for="activityLevel">Activity Level</label>
					<select name="activityLevel" id="activityLevel" class="form-control">
						<?php 
							for($i = 1; $i <= 10 ; $i++){
								print '<option value="'. $i .'"';
									print ($activityLevel == $i ) ? ' selected ' : '' ;
								print '>'. $i .'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<textarea name="generalNotes" cols="30" rows="10" class="form-control" placeholder="General Notes"><?php print $generalNotes;?></textarea>
			</div>
		</div>
		<?php
	}

	function trip_optionals(){

		$optionals = '';

?><i>To be added in Phase 2</i><?php
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


    	$trip_information = array(
    							'itinerary' => $_POST["itinerary"] ,
    							'day_image' => $_POST["day_image"] ,
    							'day_title' => $_POST["day_title"] ,
    							'meals' => $_POST["meals"] ,
    							'hotel' => $_POST["hotel"] ,
    							'date_from' => $_POST["date_from"] ,
    							'price_sgl' => $_POST["price_sgl"] ,
    							'price_dbl' => $_POST["price_dbl"] ,
    							'no_of_rooms' => $_POST["no_of_rooms"] ,
    							'includes' => $_POST["includes"] ,
    							'excludes' => $_POST["excludes"] ,
    							'generalNotes' => $_POST["generalNotes"] ,
    							'activityLevel' => $_POST["activityLevel"] ,


    						);



   		update_post_meta($post->ID, "trip_information", json_encode($trip_information));
	}

	function getAllTrips(){
		return get_posts( array(
			'post_type' => 'miami_trips'
		) );
	}

 }
<?php
get_header();
?>
<div class="container">
	<div class="col-12">
		<?php if(have_posts()): 
			while(have_posts()):
				the_post();

				$trip = get_post_meta(get_the_ID());
				$trip = $trip['trip_information'][0];
				$trip = json_decode( $trip , true);
				
				$trip_days_images = $trip['day_image'];
				$titles = $trip['day_title'];
				$itinerary = $trip['itinerary'];
				?>

				<div class="row">
					<div class="col-12">
						<h2><?php the_title(); ?></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<?php include_once('trip/glance.php'); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<?php include_once('trip/dates.php'); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<?php the_post_thumbnail(); ?>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-12">
						<?php include_once('trip/carousel.php'); ?>
					</div>
				</div>


				<div class="row">
					<div class="col-12">
						<div id="itinerary">
							<?php
							include_once('trip/itinerary.php');
							?>
						</div>
					</div>
				</div>

				<div class="row mt-4">
					<?php include_once('trip/generalnotes.php');?>
				</div>

				<div class="row mt-4">
					<?php  include_once('trip/includes.php');  ?>
				</div>
				
				<div class="row">
					<div class="col-12">
						<?php include_once('trip/form.php');  ?>
					</div>
				</div>
				<?php

			endwhile;
		endif;?>
	</div>
</div>
<?php get_footer();?>
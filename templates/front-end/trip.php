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
				
				// echo '<pre>';
				// print_r($trip);
				// echo '</pre>';
				// the_title( );
				?>

				<div class="row">
					<div class="col-12">
						<h2><?php the_title(); ?></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						Dates table
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						Carosoul day images
					</div>
				</div>


				<div class="row">
					<div class="col-12">
						Itinerary
					</div>
				</div>
				
				<div class="row">
					<div class="col-12">
						Form hidden
					</div>
				</div>
				<?php

			endwhile;
		endif;?>
	</div>
</div>
<?php get_footer();?>
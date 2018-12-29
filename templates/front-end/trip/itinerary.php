<?php 
foreach($itinerary as $key => $day){
?>

<div data-id="<?php print  $key; ?>" class="card <?php print ($key == 0)  ? ' active ' : ''; ?>">
	<div class="row">
		<div class="col-md-5">
			<?php print wp_get_attachment_image( $trip_days_images[$key] , 'full'); ?>
		</div>
		<div class="col-md-7 position-relative">
			<p class="card-text"><?php print $itinerary[$key]; ?></p>
			<div class="tripExtras col-12">
				<div class="row">
					<div class="col-6">Hotel: <?php 
						if(!empty(($trip['hotel'][$key]))){
							$hotel = get_post($trip['hotel'][$key]);
							?><a href="<?php print get_permalink($trip['hotel'][$key]); ?>">
								<?php print $hotel->post_title; ?>
							</a><?php						
						}else{
							print 'No Hotel for the night';
						}
					?></div>
					<div class="col-6">Meals: <?php 
						if(isset($trip['meals'][$key])){
							foreach($trip['meals'][$key] as $meal){
								print $meal . ', '; 
							}
						}else{
							print 'None';
						}
					?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
}
?>
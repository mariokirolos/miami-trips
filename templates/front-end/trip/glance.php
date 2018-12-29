
<h3 class="text-center">At the Glance</h3>
<?php the_excerpt(); ?>
<div class="total-information row">
	<div class="col-md-4">Total Stay: <?php  print count($itinerary); ?> nights</div>
	<div class="col-md-4">Total Meals: <?php print (isset($trip['meals'])) ?  array_sum(array_map("count", $trip['meals'])) : 0 ; ?> meals</div>
	<div class="col-md-4">Activity Level: <?php print $trip['activityLevel'];?></div>
</div>
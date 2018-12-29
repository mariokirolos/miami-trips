<h4>Dates</h4>
<div class="col-12">
	<div class="d-none d-md-block">
		<div class="row">
			<div class="col-md-3 bg-primary text-white">Date From</div>
			<div class="col-md-3 bg-primary text-white">Date To</div>
			<div class="col-md-2 bg-primary text-white">Price</div>
			<div class="col-md-4 bg-primary text-white">Availability</div>
		</div>
	</div>
	<?php 

		foreach($trip['date_from'] as $key =>$from ){
		?>
		<div class="row">
			<div class="col-md-3 bg-dark text-white"><?php print $from; ?></div>
			<div class="col-md-3"><?php print date('m-d-Y' , strtotime($from . '+ '.  count($itinerary) .' days')); ?></div>
			<div class="col-md-2">$<?php print $trip['price_dbl'][$key]; ?></div>
			<div class="col-md-4"><?php  print $trip['no_of_rooms'][$key] ?> rooms left
			
			<span   data-toggle="modal" data-target="#trip_reservation"  class="badge badge-success book-now  float-right"  data-date="<?php print $from; ?>">Book now</span>
			</div>
		</div>
		<?php
		}

	?>
	<div class="d-none d-md-block mb-1">
		<div class="row">
			<div class="col-md-3 bg-primary text-white ">Date From</div>
			<div class="col-md-3 bg-primary text-white">Date To</div>
			<div class="col-md-2 bg-primary text-white">Price</div>
			<div class="col-md-4 bg-primary text-white">Availability</div>
		</div>
	</div>
</div>
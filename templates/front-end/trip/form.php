<div class="modal fade" id="trip_reservation" tabindex="-1" role="dialog" aria-labelledby="trip_reservationLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="trip_reservationLabel">Book Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<label for="date_from">Date</label>
			<select name="date_from" class="form-control" id="date_from">
	      		<?php 
			        foreach($trip['date_from'] as $date){
			        	print '<option value="'. $date .'">'.$date.'</option>';
			        }
		        ?>
	      	</select>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Go to Payment</button>
      </div>
    </div>
  </div>
</div>
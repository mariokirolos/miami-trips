<div class="container-fluid">
    <div id="days_slider" class="carousel slide" data-ride="carousel" data-interval="9000">
        <div class="carousel-inner row w-100 mx-auto" role="listbox">
			<?php 

				foreach($trip_days_images as $key =>  $day_image){
					?>
					<div class="carousel-item col-md-3  active">
		               <div class="panel panel-default">
		                  <div class="panel-thumbnail">
		                    <a href="#" data-target="<?php print $key; ?>" class="itinerary_day" title="<?php print get_the_title($day_image);?>" class="thumb">
		                      <?php print (!empty($day_image)) ? wp_get_attachment_image( $day_image ) : '<div class="day_replacer">Day '. ($key+1) .'</div>'  ; ?>
		                    </a>
		                    <h4><?php print $titles[$key]; ?></h4>
		                  </div>
		                </div>
		            </div>
					<?php
				}

			?>
        </div>
        <a class="carousel-control-prev" href="#days_slider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next text-faded" href="#days_slider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

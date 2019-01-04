<?php if(isset( $trip['includes']) && !empty($trip['includes'])): ?>
<div class="col-6">
	<h3>Trip Includes</h3>
	<p><?php print $trip['includes'];  ?></p>
</div>
<?php endif; ?>
<?php if(isset( $trip['includes']) && !empty($trip['includes'])): ?>
<div class="col-6">
	<h3>Trip Excludes</h3>
	<p><?php print $trip['excludes'];  ?></p>
</div>
<?php endif; ?>

<?php if(isset($trip['generalNotes']) && !empty($trip['generalNotes'])): ?>
<div class="col-12 alert alert-success" id="generalInformation">
	<h3>General Notes</h3>
	<p>
		<?php print $trip['generalNotes']; ?>
	</p>
</div>
<?php endif; ?>
<div class="wrap">
	<h1>Autobody Plugin</h1>
	<?php settings_errors(); ?>

	
	<form method="POST" action="options.php">
		<?php 
			settings_fields('Autobody_group');
			do_settings_sections('Autobody');
			submit_button();
		?>
	</form>

</div>
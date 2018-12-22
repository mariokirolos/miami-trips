<!DOCTYPE html>
<html>
<head>
	<title>Search Page</title>
	<?php wp_head();?>
</head>
<body style="background: pink ">
	<div class="row justify-content-md-center">
		<div class="col-6">
			<div id="searchForm">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
the_content();
endwhile; ?>
<?php endif; ?>
		
			</div>		
		</div>
	</div>	
<?php wp_footer(); ?>
</body>
</html>
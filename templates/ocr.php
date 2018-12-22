<div class="wrap">
	<h1>OCR</h1>


	<?php settings_errors(); ?>


	<ul class="nav nav-tabs">
		<li class="active"><a href="#table">Table</a></li>
		<?php 

		$option = get_option('Autobody_group');
		if(!empty($option['autobody_ocr_api'])): ?>
			<li ><a href="#upload">Upload</a></li>
		<?php endif; ?>
	</ul>

	<div class="tab-content">
		<div id="table" class="tab-pane active">


	<?php 
		Use Inc\Base\Database;
		$database = new Database();
		$list = $database->getOCRList();
	?>
	<div class="table-wrap">
		<table class="wp-list-table widefat autobodyocr">
	<thead>
	<tr>
		<th width="10%" scope="col">#</th><th width="10%" scope="col">Thumb</th><th width="50%" scope="col" id="name" class="manage-column column-name column-primary">Text</th><th width="25%" scope="col">Date Created</th><th scope="col" width="15%" id="ip-address" class="manage-column">IP Address</th>	</tr>
	</thead>

	<tbody id="the-list">
		<?php
		$i = 1;
		foreach($list as $key => $item):
		?>
		<tr>
			<td><?php print $i; ?></td>
			<td><a href="<?php print $item->full_image_src; ?>"  target="_blank"><img class="table-thumb" src="<?php print $item->thumb_image_src;?>" /></a></td>
			<td><?php print $item->convertedText;?></td>
			<td><?php  print $item->date_created; ?></td>
			<td><?php print $item->ip_address; ?></td>
			<!-- <td><a href="edit.php?id=<?php print $item->id ?>">Edit</a> <a href="delete.php?id=<?php print $item->id ?>">Delete</a></td> -->
		</tr>


		<?php
		$i++;
		endforeach;
		?>
	</tbody>

	<tfoot>
	<tr>
		<th scope="col">#</th><th width="10%" scope="col">Thumb</th><th scope="col" class="manage-column column-name column-primary">Text</th><th width="10" scope="col">Date Created</th><th scope="col" class="manage-column">IP Address</th></tr>
	</tfoot>

</table>
	</div>

		</div>
		<?php 
		if(!empty($option['autobody_ocr_api'])): ?>
			<div id="upload" class="tab-pane">

			<h3>Upload Your Image from here</h3>
			<form action="" method="POST" enctype="multipart/form-data">
				<input type="file" id="uploadOCR" name="uploadOCR" />
				<div id="message"></div>
				<?php wp_nonce_field( 'ocr_upload', 'ocr_upload_nonce' ); ?>
				<?php submit_button( 'Upload' ,'primary', 'uploadOCRBTN' ); ?>
			</form>

			</div>
		<?php else: ?>
			<p style="font-style: italic;color:red; ">In Order to open the Upload form, please provide your API key</p>
		<?php endif; ?>
	</div>


</div>
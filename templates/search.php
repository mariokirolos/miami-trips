<div class="wrap">
	<h1>Autobody Search</h1>
	<?php settings_errors();?>
	<?php 
		Use Inc\Base\Database;
		$database = new Database();
		$list = $database->getList();
	?>
	<div class="table-wrap">
		<table class="wp-list-table widefat autobodysearch">
	<thead>
	<tr>
		<th width="10%" scope="col">#</th><th width="50%" scope="col" id="name" class="manage-column column-name column-primary">Word</th><th width="25%" scope="col">Date Created</th><th scope="col" width="15%" id="ip-address" class="ip-address">IP Address</th>	</tr>
	</thead>

	<tbody id="the-list">
		<?php
		$i = 1;
		foreach($list as $key => $item):
		?>
		<tr>
			<td><?php print $i; ?></td>
			<td><?php print $item->name;?></td>
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
		<th scope="col">#</th><th scope="col" class="manage-column column-name column-primary">Word</th><th width="10" scope="col">Date Created</th><th scope="col" class="ip-address">IP Address</th></tr>
	</tfoot>

</table>
	</div>
</div>
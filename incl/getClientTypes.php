<?php
	session_start();
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');

  //Get list of clients
	$clients_query = mysql_query('
		SELECT
			*
		FROM
			ksg3_passwords.clients
		ORDER BY
			client_name
		ASC
	');

	$clients = '
    <thead>
   		<tr class="head">
   			<th class="headerSortUnsorted headerSortDesc">Client Name</th>
            <th class="headerSortUnsorted headerSortDesc">Client Description</th>
   			<th>Options</th>
   		</tr>
   	</thead>
   	<tbody>
  ';
	while ($row = mysql_fetch_array($clients_query)){
		$clients .= '
			<tr>
				<td>'.$row['client_name'].' <input type="hidden" value="'.$row['id'].'" /></td>
        <td>'.$row['client_description'].'</td>
				<td>
					<a href="#" class="editClient" title="Edit..."><img src="images/icons/edit_icon.png" alt="Edit..." width="24" height="24" /></a>&nbsp;
					<a href="#" class="deleteClient" title="Delete..."><img src="images/icons/delete_icon.png" alt="Delete..." width="24" height="24" rel="deleteButton" /><img src="images/anims/mini_saving.gif" alt="Deleting..." width="24" height="24" rel="deleteAnim" style="display: none;" /></a>
				</td>
			</tr>
		';
	}
  $clients .= '</tbody>';
		
	 echo $clients;
?>

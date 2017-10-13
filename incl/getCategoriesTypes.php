<?php
	session_start();
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');

  //Get list of categorys
	$categorys_query = mysql_query('
		SELECT
			*
		FROM
			ksg3_passwords.categories
		ORDER BY
			title
		ASC
	');

	$categories = '
    <thead>
   		<tr class="head">
   			<th class="headerSortUnsorted headerSortDesc">Category Title</th>
            <th class="headerSortUnsorted headerSortDesc">Category Description</th>
   			<th>Options</th>
   		</tr>
   	</thead>
   	<tbody>
  ';
	while ($row = mysql_fetch_array($categorys_query)){
		$categories .= '
			<tr>
				<td>'.$row['title'].' <input type="hidden" value="'.$row['id'].'" /></td>
        <td>'.$row['description'].'</td>
				<td>
					<a href="#" class="editCategory" title="Edit..."><img src="images/icons/edit_icon.png" alt="Edit..." width="24" height="24" /></a>&nbsp;
					<a href="#" class="deleteCategory" title="Delete..."><img src="images/icons/delete_icon.png" alt="Delete..." width="24" height="24" rel="deleteButton" /><img src="images/anims/mini_saving.gif" alt="Deleting..." width="24" height="24" rel="deleteAnim" style="display: none;" /></a>
				</td>
			</tr>
		';
	}
  $categories .= '</tbody>';
		
	 echo $categories;
?>

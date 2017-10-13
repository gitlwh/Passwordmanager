<?php
	session_start();
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');
	
	$id = $_POST['id'];
	$success = 0;
	$message = '';
	
	if ($id=='All'){
		$query = mysql_query('
			SELECT
				a.*,
				b.title,
				c.client_name
			FROM
				ksg3_passwords.passwords a,
				ksg3_passwords.categories b,
				ksg3_passwords.clients c
			WHERE
				b.id = a.category_id AND
				c.id = a.client_id AND
					a.min_access_level >= '.$_SESSION['access_level']
			);
		} else {
			$query = mysql_query('
				SELECT
					a.*,
					b.title,
					c.client_name
				FROM
					ksg3_passwords.passwords a,
					ksg3_passwords.categories b,
					ksg3_passwords.clients c
				WHERE
					a.client_id = '.$id.' AND
					b.id = a.category_id AND
					c.id = a.client_id AND
					a.min_access_level >= '.$_SESSION['access_level']
				);
		}
		
		$passwords = '
			<thead>
    		<tr class="head">
    			<th class="headerSortUnsorted headerSortDesc">Client Name</th>
    			<th class="headerSortUnsorted">Password Type</th>
    			<th class="headerSortUnsorted">Username</th>
    			<th class="headerSortUnsorted">Password</th>
    			<th class="headerSortUnsorted">Hostname</th>
    			<th class="headerSortUnsorted">Comments</th>
    			<th>Options</th>
    		</tr>
    	</thead>
    	<tbody>
		';
		while ($row = mysql_fetch_array($query)){
			$passwords .= '
				<tr id="password'.$row['id'].'" class="highlight">
					<td>'.$row['client_name'].' <input type="hidden" value="'.$row['id'].'" /></td>
					<td>'.$row['title'].'</td>
					<td>'.$row['username'].'</td>
					<td>'.$row['password'].'</td>
				';
				
				if (substr(strtolower($row['hostname']), 0, 7)!='http://') $row['hostname'] = 'http://'.$row['hostname'];
				
				$passwords .= '
					<td><a href="'.$row['hostname'].'" target="_blank">'.$row['hostname'].'</a></td>
					<td>'.$row['comments'].'</td>
					<td>
						<a href="#" class="editPassword" title="Edit..."><img src="images/icons/edit_icon.png" alt="Edit..." width="24" height="24" /></a>&nbsp;
						<a href="#" class="deletePassword" title="Delete..."><img src="images/icons/delete_icon.png" alt="Delete..." width="24" height="24" rel="deleteButton" /><img src="images/anims/mini_saving.gif" alt="Deleting..." width="24" height="24" rel="deleteAnim" style="display: none;" /></a>
					</td>
				</tr>
			';
		}
		$passwords .= '</tbody>';
		
		echo $passwords;
?>

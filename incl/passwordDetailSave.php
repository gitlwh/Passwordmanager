<?php
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');
	
	//Get all post variables
	$id = $_POST['id'];
	$method = $_POST['method'];
	$client_id = $_POST['client_id'];
	$category_id = $_POST['category_id'];
	if ($method!='delete'){
		$hostname = $_POST['hostname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$comments = $_POST['comments'];
		$status_id = $_POST['status_id'];
	}
	
	//Get client name and category name
	$get_query = mysql_query('
		SELECT
			a.client_name,
			b.title as category_title
		FROM
			ksg3_passwords.clients a,
			ksg3_passwords.categories b
		WHERE
			a.id = '.$client_id.' AND
			b.id = '.$category_id.'
		LIMIT 1
	');
	
	$get_row = mysql_fetch_array($get_query);
	
	//Determine method and act accordingly
	if ($method=='add'){
		$description = 'Added '.$get_row['category_title'].' password for '.$get_row['client_name'];
		$query = mysql_query('
			INSERT INTO
				ksg3_passwords.passwords
			(client_id, category_id, username, password, hostname, comments, min_access_level, status_id)
			VALUES ('.$client_id.', '.$category_id.', "'.$username.'", "'.$password.'", "'.$hostname.'", "'.$comments.'", 3, '.$status_id.')
		');
		$lastInsertId = mysql_insert_id();
		$recent_activity_query = mysql_query('
			INSERT INTO
				ksg3_passwords.recent_activity
			(category_id, client_id, password_id, description)
			VALUES ('.$category_id.', '.$client_id.', '.$lastInsertId.', "'.$description.'")
		');
	} else if ($method=='update'){
		$description = 'Updated '.$get_row['category_title'].' password for '.$get_row['client_name'];
		$query = mysql_query('
			UPDATE ksg3_passwords.passwords
			SET
				client_id = "'.$client_id.'",
				category_id = "'.$category_id.'",
				hostname = "'.$hostname.'",
				username = "'.$username.'",
				password = "'.$password.'",
				comments = "'.$comments.'",
				status_id = "'.$status_id.'"
			WHERE
				id = '.$id
		);
		$recent_activity_query = mysql_query('
			INSERT INTO
				ksg3_passwords.recent_activity
			(category_id, client_id, password_id, description)
			VALUES ('.$category_id.', '.$client_id.', '.$id.', "'.$description.'")
		');
	} else if ($method=='delete'){
		$description = 'Deleted '.$get_row['category_title'].' password for '.$get_row['client_name'];
		$query = mysql_query('
			DELETE FROM ksg3_passwords.passwords WHERE id='.$id.' LIMIT 1
		');
		$recent_activity_query = mysql_query('
			INSERT INTO
				ksg3_passwords.recent_activity
			(category_id, client_id, password_id, description)
			VALUES ('.$category_id.', '.$client_id.', '.$id.', "'.$description.'")
		');
	}
	
	//Determine if query succeeded and echo out result accordingly
	if ($query){
		echo '<span style="color: #00DF1E;">The password was saved successfully!</span>';
	} else {
		echo '<span style="color: #DF0000;">The password failed to save!</span>';
	}
?>

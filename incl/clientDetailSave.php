<?php
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');

  $method = mysql_real_escape_string($_POST['method']);
  switch($method){
	  case 'add':
	    $client_name = mysql_real_escape_string($_POST['client_name']);
      $client_description = mysql_real_escape_string($_POST['client_description']);
      $status_id = mysql_real_escape_string($_POST['status_id']);
      $query = mysql_query('
        INSERT INTO
          ksg3_passwords.clients
        (client_name, client_description, status_id)
        VALUES("'.$client_name.'", "'.$client_description.'", '.$status_id.')
      ');
      $description = 'Added client '.$client_name;
  		$lastInsertId = mysql_insert_id();
  		$recent_activity_query = mysql_query('
  			INSERT INTO
  				ksg3_passwords.recent_activity
  			(category_id, client_id, password_id, description)
  			VALUES (0, '.$lastInsertId.', '.$lastInsertId.', "'.$description.'")
  		');
      break;
    case 'update':
      $id = mysql_real_escape_string($_POST['id']);
	    $client_name = mysql_real_escape_string($_POST['client_name']);
      $client_description = mysql_real_escape_string($_POST['client_description']);
      $status_id = mysql_real_escape_string($_POST['status_id']);
      $query = mysql_query('
        UPDATE
          ksg3_passwords.clients
        SET
          client_name = "'.$client_name.'", client_description = "'.$client_description.'", status_id = '.$status_id.'
        WHERE
          id = '.$id
      );
      $description = 'Added client '.$client_name;
  		$lastInsertId = mysql_insert_id();
  		$recent_activity_query = mysql_query('
  			INSERT INTO
  				ksg3_passwords.recent_activity
  			(category_id, client_id, password_id, description)
  			VALUES (0, '.$lastInsertId.', '.$lastInsertId.', "'.$description.'")
  		');
      break;
    case 'delete':
      $id = mysql_real_escape_string($_POST['id']);
      $client_name = mysql_real_escape_string($_POST['client_name']);
      $description = 'Deleted "'.$client_name.'"';
  		$query = mysql_query('
  			DELETE FROM ksg3_passwords.clients WHERE id='.$id.' LIMIT 1
  		');
  		$recent_activity_query = mysql_query('
  			INSERT INTO
  				ksg3_passwords.recent_activity
  			(category_id, client_id, password_id, description)
  			VALUES (0, '.$id.', '.$id.', "'.$description.'")
  		');
      break;
  }

	//Determine if query succeeded and echo out result accordingly
	if ($query){
		echo '<span style="color: #00DF1E;">The password was saved successfully!</span>';
	} else {
		echo '<span style="color: #DF0000;">The password failed to save!</span>';
	}
?>

<?php
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');

  $method = mysql_real_escape_string($_POST['method']);
  switch($method){
	  case 'add':
	    $category_title = mysql_real_escape_string($_POST['category_title']);
      $category_description = mysql_real_escape_string($_POST['category_description']);
      $query = mysql_query('
        INSERT INTO
          ksg3_passwords.categories
        (title, description)
        VALUES("'.$category_title.'", "'.$category_description.'")
      ');
      $description = 'Added category '.$category_title;
  		$lastInsertId = mysql_insert_id();
      break;
    case 'update':
      $id = mysql_real_escape_string($_POST['id']);
	    $category_title = mysql_real_escape_string($_POST['category_title']);
      $category_description = mysql_real_escape_string($_POST['category_description']);
      $query = mysql_query('
        UPDATE
          ksg3_passwords.categories
        SET
          title = "'.$category_title.'", description = "'.$category_description.'"
        WHERE
          id = '.$id
      );
      $description = 'Added category '.$category_title;
  		$lastInsertId = mysql_insert_id();
      break;
    case 'delete':
      $id = mysql_real_escape_string($_POST['id']);
  		$query = mysql_query('
  			DELETE FROM ksg3_passwords.categories WHERE id='.$id.' LIMIT 1
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

<?php
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');
	
	$method = $_POST['method'];
	switch($method){
		case 'add':
  		$id = 0;
  		$categoryDetail = Array('id' => '', 'title' => '', 'description' => '');
      $header = 'Add New Category';
      break;
	  case 'update':
  		$id = $_POST['id'];
  		//Get detail for current category
  		$query = mysql_query('
  			SELECT
  				*
  			FROM
  				ksg3_passwords.categories
  			WHERE
  				id = '.$id
  		);
      if (!$query) echo 'Error: '.mysql_error();
  		//Put mysql result into an array
  		$categoryDetail = mysql_fetch_array($query);
      $header = 'Editing Category';
      break;
  }
	
	//Generate final html
	$detailHtml = '
		<input type="hidden" id="hidCategoryDetailId" value="'.$id.'" />
		<h1>'.$header.'</h1>
		<table class="detailForm">
			<tr>
        <td>Category Title:</td>
      </tr>
      <tr>
				<td><input type="text" id="txtCategoryTitle" value="'.$categoryDetail['title'].'" /></td>
			</tr>
      <tr>
        <td>Category Description:</td>
      </tr>
      <tr>
        <td><textarea id="txtCategoryDescription" name="txtCategoryDescription" rows="5" cols="30">'.$categoryDetail['description'].'</textarea></td>
      </tr>
			<tr>
				<td id="categoryDetailButtons">
					<input type="button" id="btnCategoryDetailSave" value="Save" class="'.$method.'" /> &nbsp;
					';
					if ($method=='update') $detailHtml .= '<input type="button" id="btnCategoryDetailDelete" value="Delete" class="'.$method.'" /> &nbsp;';
					$detailHtml .= '
					<input type="button" id="btnCategoryDetailCancel" value="Close" class="btnCancel" /><br />
					<span id="categoryDetailResultMessage"></span>
				</td>
				<td id="categoryDetailSaving" style="display: none;">Saving... Please wait...</td>
			</tr>
		</table>
	';
	
	//Return html for ajax call
	echo $detailHtml;
?>

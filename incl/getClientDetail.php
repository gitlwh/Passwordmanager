<?php
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');
	
	$method = $_POST['method'];
	switch($method){
		case 'add':
  		$id = 0;
  		$clientDetail = Array('client_id' => '', 'client_name' => '', 'client_description' => '',  'status_id' => 1);
      $header = 'Add New Client';
      break;
	  case 'update':
  		$id = $_POST['id'];
  		//Get detail for current client
  		$query = mysql_query('
  			SELECT
  				*
  			FROM
  				ksg3_passwords.clients
  			WHERE
  				id = '.$id
  		);
      if (!$query) echo 'Error: '.mysql_error();
  		//Put mysql result into an array
  		$clientDetail = mysql_fetch_array($query);
      $header = 'Editing Client';
      break;
  }
	
	//Generate final html
	$detailHtml = '
		<input type="hidden" id="hidClientDetailId" value="'.$id.'" />
		<h1>'.$header.'</h1>
		<table class="detailForm">
			<tr>
        <td>Client Name:</td>
        <td>Client Status:</td>
      </tr>
      <tr>
				<td><input type="text" id="txtClientName" value="'.$clientDetail['client_name'].'" /></td>
				<td>
					<select id="selClientDetailStatus">
						';

						if ($clientDetail['status_id']==1){
							$detailHtml .= '
								<option value="1" selected="true">Active</option>
								<option value="0">Inactive</option>
							';
						} else {
							$detailHtml .= '
								<option value="1">Active</option>
								<option value="0" selected="true">Inactive</option>
							';
						}
						
						$detailHtml .= '
					</select>
				</td>
			</tr>
      <tr>
        <td>Client Description:</td>
      </tr>
      <tr>
        <td><textarea id="txtClientDescription" name="txtClientDescription" rows="5" cols="30">'.$clientDetail['client_description'].'</textarea></td>
      </tr>
			<tr>
				<td id="clientDetailButtons">
					<input type="button" id="btnClientDetailSave" value="Save" class="'.$method.'" /> &nbsp;
					';
					if ($method=='update') $detailHtml .= '<input type="button" id="btnClientDetailDelete" value="Delete" class="'.$method.'" /> &nbsp;';
					$detailHtml .= '
					<input type="button" id="btnClientDetailCancel" value="Close" class="btnCancel" /><br />
					<span id="clientDetailResultMessage"></span>
				</td>
				<td id="clientDetailSaving" style="display: none;">Saving... Please wait...</td>
			</tr>
		</table>
	';
	
	//Return html for ajax call
	echo $detailHtml;
?>

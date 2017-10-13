<?php
	require_once('constants.incl.php');
	require_once('common.incl.php');
	require_once('db.incl.php');
	
	$method = $_POST['method'];
	if ($method=='add'){
		$id = 0;
		$passwordDetail = Array('client_id' => '', 'category_id' => '', 'username' => '', 'password' => '', 'hostname' => '', 'comments' => '', 'status_id' => 1);
	} else {
		$id = $_POST['id'];
		//Get detail for current password
		$query = mysql_query('
			SELECT
				a.*,
				b.title,
				c.client_name,
				d.host_name
			FROM
				ksg3_passwords.passwords a,
				ksg3_passwords.categories b,
				ksg3_passwords.clients c,
				ksg3_passwords.host d
			WHERE
				a.id = '.$id.' AND
				b.id = a.category_id AND
				c.id = a.client_id AND
				d.id = c.client_host_id
		');
	
		if (!$query) echo 'Error: '.mysql_error();
		//Put mysql result into an array
		$passwordDetail = mysql_fetch_array($query);
	}
	
	//Get list of clients
	$clientsQuery = mysql_query('
		SELECT
			*
		FROM
			ksg3_passwords.clients
		WHERE
			status_id = 1
	');
	
	//Loop through clients and make an options list of them
	$clientsList = '<select id="selPasswordDetailClients"><option value="">Select Client...</option>';
	while ($row = mysql_fetch_array($clientsQuery)){
		if ($row['id']==$passwordDetail['client_id']){
			$clientsList .= '<option value="'.$row['id'].'" selected="true">'.$row['client_name'].'</option>';
		} else {
			$clientsList .= '<option value="'.$row['id'].'">'.$row['client_name'].'</option>';
		}
	}
	$clientsList .= '</select>';
	
	//Get all categories that are active
	$categoryQuery = mysql_query('
		SELECT
			*
		FROM
			ksg3_passwords.categories
	');
	
	//Loop through categories and make an options list of them
	$categoryList = '<select id="selPasswordDetailCategories"><option value="">Select Category...</option>';
	while($row = mysql_fetch_array($categoryQuery)){
		if ($row['id']==$passwordDetail['category_id']){
			$categoryList .= '<option value="'.$row['id'].'" selected="true">'.$row['title'].'</option>';
		} else {
			$categoryList .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
		}
	}
	$categoryList .= '</select>';
	
	
	//Get all hosts that are active
	/*$hostsQuery = mysql_query('
		SELECT
			*
		FROM
			ksg3_passwords.host
	');
	
	//Loop through categories and make an options list of them
	$hostsList = '<select id="selPasswordDetailHosts"><option value="">Select Host...</option>';
	while($row = mysql_fetch_array($hostsQuery)){
		if ($row['id']==$passwordDetail['host_name_id']){
			$hostsList .= '<option value="'.$row['id'].'" selected="true">'.$row['host_name'].'</option>';
		} else {
			$hostsList .= '<option value="'.$row['id'].'">'.$row['host_name'].'</option>';
		}
	}
	$hostsList .= '</select>';*/
	
	//Generate final html
	if ($method=='update') $header = 'Editing Password'; else $header = 'Add New Password';
	$detailHtml = '
		<input type="hidden" id="hidPasswordDetailId" value="'.$id.'" />
		<h1>'.$header.'</h1>
		<table class="detailForm">
			<tr>
				<td colspan="2">'.$clientsList.'</td>
			</tr>
			<tr>
				<td colspan="2">'.$categoryList.'</td>
			</tr>
			<tr>
				<td>URL/Hostname</td>
				<td>Status</td>
			</tr>
			<tr>
				<td><input type="text" id="txtPasswordDetailHostname" value="'.$passwordDetail['hostname'].'" /></td>
				<td>
					<select id="selPasswordDetailStatus">
						';
						
						if ($passwordDetail['status_id']==1){
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
				<td>Username</td>
				<td>Password</td>
			</tr>
			<tr>
				<td><input type="text" id="txtPasswordDetailUsername" value="'.$passwordDetail['username'].'" /></td>
				<td><input type="text" id="txtPasswordDetailPassword" value="'.$passwordDetail['password'].'" /></td>
			</tr>
			<tr>
				<td>Comments</td>
			</tr>
			<tr>
				<td colspan="2"><textarea id="txtPasswordDetailComments" rows="7" cols="23">'.$passwordDetail['comments'].'</textarea></td>
			</tr>
			<tr>
				<td id="passwordDetailButtons">
					<input type="button" id="btnPasswordDetailSave" value="Save" class="'.$method.'" /> &nbsp;
					';
					if ($method=='update') $detailHtml .= '<input type="button" id="btnPasswordDetailDelete" value="Delete" class="'.$method.'" /> &nbsp;';
					$detailHtml .= '
					<input type="button" id="btnPasswordDetailCancel" value="Close" class="btnCancel" /><br />
					<span id="passwordDetailResultMessage"></span>
				</td>
				<td id="passwordDetailSaving" style="display: none;">Saving... Please wait...</td>
			</tr>
		</table>
	';
	
	//Return html for ajax call
	echo $detailHtml;
?>

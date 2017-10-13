<?php
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>KSA&D Interactive Passwords</title>


	<link media="all" href="/styles/global.css" type="text/css" rel="stylesheet">
	<link media="all" href="/styles/main.css" type="text/css" rel="stylesheet">

<script type="text/javascript">
function goTo() {
var sE = null, url;
if(document.getElementById) {
sE = document.getElementById('urlList');
} else if(document.all) {
sE = document.all['urlList'];
}
if(sE && (url = sE.options[sE.selectedIndex].value)) {
location.href = url;
}
}
</script>
</head>
<body>
	<div id="wrapper" class="sub news">
    <div id="topHeader">
    	<?php include('incl/topHeader.incl.php'); ?>
    </div>
    <div id="topNav">
	  	<?php include('incl/topNav.incl.php'); ?>
  
    </div>
    <div class="left" id="main">
			<div class="white" id="middle">
        <div id="center_content">
          <div class="center_module" id="news_main">
          	
						<div id="welcomeText" style="height: 50px;">
							<h2>Edit Password</h2>
							<form class="jqTransform">
								<table>
									<tr class="heading">
										<td>Clients</td>
										<!-- <td>Password Type</td> -->
									</tr>
									<tr>
										<td>
											
										</td>
										<!-- <td>
											<select id="selSearchPasswords">
												<option value="Select Password Type..." selected="true">Select Password Type...</option>
											</select>
										</td> -->
									</tr>
								</table>
							</form>
						</div>
						<div id="recentActivity">
							
							<table class="admin" id="tableResults">
								<thead>
								    <tr class="head">
								      <th>Username</th>
								      <th>Password</th>
								      <th>URL</th>
								      <th>Description</th>
											<th>Comments</th>
											<th>&nbsp;</th>
								    </tr>
								  </thead>
		          	</thead>
		          	<tbody>
									<?php $query = $this->db->query("SELECT id, client_id, username, aes_decrypt(encrypted_password, 'ksand3102') password, url, description, comments FROM passwords WHERE id = '$id'"); ?>
									<tr>
										<form action="#" method="POST">
											<?php if ($query->num_rows() > 0)
											{
											   foreach ($query->result() as $row)
											   {
											      echo '<td><input type="text" name="username" value="' . $row->username . '"></input></td>';
											      echo '<td><input type="text" name="password" value="' . $row->password . '"></input></td>';
											      echo '<td><input type="text" name="url" value="' . $row->url . '"></input></td>';
											      echo '<td><input type="text" name="description" value="' . $row->description . '"></input></td>';
											      echo '<td><input type="text" name="comments" value="' . $row->comments . '"></input></td>';
														echo '<td><input type="submit" value="Update" /></td>';
											   }
											} ?>
										</form>
									</tr>
								</tbody>
						</table>
						</div>
          </div>
        </div>
      </div>
</body>
</html>
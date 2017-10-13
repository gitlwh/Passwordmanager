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
							<h2>Edit Client</h2>
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
							<form action="#" method="POST" >
							<table class="admin" id="tableResults">
								<thead>
								    <tr class="head">
								      <th>Client Name</th>
								      <th>Client URL</th>
								      <th>&nbsp;</th>
								      <th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
								    </tr>
								  </thead>
		          	</thead>
		          	<tbody>
									<tr>
										<?php $query = $this->db->query("SELECT * FROM clients WHERE id='$id'"); 
										foreach ($query->result() as $row)
										{ ?>
										<td><input type="text" name="client-name" value="<?php echo $row->name; ?>" size="50" /></td>
										<td><input type="text" name="client-url" value="<?php echo $row->url; ?>" size="50" /></td>
										<td><input type="submit" value="Submit" /></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									<?php } ?>
																	</tr>
								</tbody>
						</table>
						</form>
						</div>
						<div>
                        <a href="add_client" style="display: inline-block;
    margin: 5px;">Back to all</a>
                    </div>
          </div>
        </div>
      </div>
</body>
</html>
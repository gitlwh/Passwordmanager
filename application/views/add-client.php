<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>KSA&D Interactive Passwords</title>

	<link media="all" href="/styles/global.css" type="text/css" rel="stylesheet">
	<link media="all" href="/styles/main.css" type="text/css" rel="stylesheet">
<style>
	.center_module{
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

</style>
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
          	
						<div id="welcomeText" style="height: 40px;">
							<h2>Add a Client</h2>
						</div>
	<form action="#" method="POST">
		<table width="250" style="font-size: 10pt">
			<tr><td><label for="client-name">Client Name</label></td>
		<td><input type="text" name="client-name" /></td></tr>
			<tr><td><label for="client-url">Client URL</label></td>
		<td><input type="text" name="client-url" /></td></tr>
		<tr><td><input type="submit" value="Submit" /></td></tr>
		</table>
	</form>
	
	<div id="recentActivity" style="margin-top: 50px;">
		<table class="admin" id="tableResults">
			<thead>
			    <tr class="head">
				    <th>Client Name</th>
				    <th>URL</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
			</thead>
			<tbody>
				<?php $query = $this->db->query("SELECT * FROM clients ORDER BY name ASC"); 
				foreach ($query->result() as $row)
				{
			  	echo '<tr><td><a href="/index.php/passwords?client=' . $row->id . '">' . $row->name . '</a></td>';
			  	echo '<td><a href="' . $row->url . '">' . $row->url . '</a></td>';
					echo '<td><a href="/index.php/passwords/edit_client?id=' . $row->id .'">Edit Client</a></td>';
					echo '<td><a onClick="return confirm(\'Are you sure you want to delete this client and all of their passwords?\');" href="/index.php/passwords/delete_client?id=' . $row->id .'">Delete Client</a></td></tr>';
				}

				?>
			</tbody>
		</table>
	</div>
						</div>
          </div>
        </div>
      </div>
</body>
</html>
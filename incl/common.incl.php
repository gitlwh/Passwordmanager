<?php
	function generate_client_link($client_id, $client_name, $attr = ''){
		return '<a href="view_passwords.php?id='.$client_id.'" '.$attr.'>'.$client_name.'</a>';
	}
?>

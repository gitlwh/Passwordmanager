<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passwords extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library('session');
		if(!isset($_GET['bypass_auth'])) {
			if(!$this->session->userdata('logged_in')) {
				redirect('/home/login/');
			}
		}	
	}

	public function index()
	{	

		if(isset($_POST['username'])) {
			$clientname = $this->db->escape_str($_POST['clientname']);
			//echo '<script language="javascript">alert("'.$clientname.'");</script>';
			$username = $this->db->escape_str($_POST['username']);
			$password = $this->db->escape_str($_POST['password']);
			$password_confirm = $this->db->escape_str($_POST['confirm-password']);
			$url = $this->db->escape_str($_POST['url']);
			$description = $this->db->escape_str($_POST['description']);
			$comments = $this->db->escape_str($_POST['comments']);
			$client_id = $this->db->escape_str($_POST['client']);

			if($clientname==""){
				echo '<script language="javascript">
				alert("Choose client name!");
				</script>';
			}
			elseif (filter_var($url, FILTER_VALIDATE_URL) === FALSE&&$url!='') {
				echo '<script language="javascript">
				alert("Input valid address!");
				</script>';
			}elseif($password != $password_confirm) {
				echo '<script language="javascript">
				alert("Passwords do not match!");
				</script>';
			} else {
				
				$a = "SELECT id FROM clients WHERE name='$clientname'";
				$query = $this->db->query($a);
				foreach ($query->result() as $row) {
                    $client_id=$row->id;
                }
				$a = "INSERT INTO passwords (username, encrypted_password, url, description, comments, client_id) VALUES('$username', aes_encrypt('$password', 'ksand3102'), '$url', '$description', '$comments', '$client_id')";

				$this->db->simple_query($a);
				/*
				$data = array(
			        'username' => $username,
			        'encrypted_password' => $password,
			        'url' => $url,
			        'description' => $description,
			        'comments' => $comments,
			        'client_id' => $client_id
				);
				$this->db->insert('passwords', $data);
				*/


				//$sql = mysql_query("INSERT INTO passwords (username, encrypted_password, url, description, comments, client_id) VALUES('$username', aes_encrypt('$password', 'ksand3102'), '$url', '$description', '$comments', '$client_id')");
				//echo "SQL = $a<BR><BR>";
			}
		}
		
		$this->load->view('passwords');
	}
	
	public function add_client()
	{
		$this->load->helper('url');
		
		$message = ' ';
		
		if(isset($_POST['client-name'])) {
			$client = $this->db->escape_str($_POST['client-name']);
			$query = $this->db->get_where('clients', array('name' => $client));
			if(sizeof($query->result())!=0){
				echo '<script language="javascript">
				alert("Duplicated name!");
				</script>';
			}else{
				
				$url = $this->db->escape_str($_POST['client-url']);


				if (filter_var($url, FILTER_VALIDATE_URL) === FALSE&&$url!='') {
					echo '<script language="javascript">
					alert("Input valid url!");
					</script>';
				}else{
					$data = array(
				        'name' => $client,
				        'url' => $url
					);
					$this->db->insert('clients', $data);
					//$sql = mysql_query("INSERT INTO clients (name, url) VALUES ('$client', '$url')");
					$inserted = $this->db->insert_id();
					$redirect_url = '/passwords?client=' . $inserted . '';
					
					redirect($redirect_url);
				}

				

			}
			
			
		}
		
		$this->load->view('add-client');
		
	}
	
	public function edit_client() {
		$this->load->helper('url');
		
		if(isset($_POST['client-name'])) {
			$id = $_GET['id'];
			$name = $this->db->escape_str($_POST['client-name']);
			$url = $this->db->escape_str($_POST['client-url']);
			$query = $this->db->get_where('clients', array('name' => $name,'id !='=>$id));
			//$query = "SELECT * FROM clients WHERE id!='$id' and name='$name"

		//$sql = mysql_query("UPDATE clients SET name='$name', url='$url' WHERE id='$id'");
			if(sizeof($query->result())!=0){
				echo '<script language="javascript">
				alert("Duplicated name!");
				</script>';
			}else{
				$data = array(
	        'name' => $name,
	        'url' => $url
		);

		$this->db->where('id', $id);
		$this->db->update('clients', $data);

		redirect('/passwords/add_client');
			}
		
		
	}
	
	$this->load->view('edit-client');
}
	
	public function delete_client() {
		$this->load->helper('url');
		
		
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$this->db->delete('clients', array('id' => $id));
			$this->db->delete('passwords', array('client_id' => $id));
			$redirect_url = '/passwords/';
			redirect($redirect_url);
			
			
		}
	}
	
	public function edit_password()
	{
		
		$invalid = isset($_GET["invalid"])?$_GET["invalid"]:FALSE;
		//echo '<script language="javascript">alert('.$invalid.');</script>';
		
		$this->load->helper('url');
		if(isset($_POST['username'])) {
			$id = $_GET['id'];
			/*
			$username = mysql_real_escape_string($_POST['username']);
			$password = mysql_real_escape_string($_POST['password']);
			$url = mysql_real_escape_string($_POST['url']);
			$description = mysql_real_escape_string($_POST['description']);
			$comments = mysql_real_escape_string($_POST['comments']);
			*/
			$username = $this->db->escape_str($_POST['username']);
			$password = $this->db->escape_str($_POST['password']);
			$url = $this->db->escape_str($_POST['url']);
			$description = $this->db->escape_str($_POST['description']);
			$comments = $this->db->escape_str($_POST['comments']);
			$update = time();
			$client_id = $_GET['client'];
			$redirect_url = '/passwords?client=' . $client_id . '';
			
			
			//$sql = mysql_query("UPDATE passwords SET username='$username', encrypted_password=aes_encrypt('$password', 'ksand3102'), url='$url', description='$description', comments='$comments', date_updated = '$update' WHERE id='$id'");
			/*
			$data = array(
			        'username' => $username,
			        'encrypted_password' => $password,
			        'url' => $url,
			        'description' => $description,
			        'comments' => $comments,
			        'date_updated' => $update
			);

			$this->db->where('id', $id);
			$this->db->update('Passwords', $data);
			*/
			//print_r($url);
			//$this->db->query("UPDATE passwords SET username='$username', encrypted_password=aes_encrypt('$password', 'ksand3102'), url='$url', description='$description', comments='$comments', date_updated = '$update' WHERE id='$id'");
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE&&$url!='') {
					
					
					$invalid = true;
					redirect('passwords/edit_password?id='.$id.'&client='.$client_id.'&invalid='.$invalid);
				}else{
					$this->db->query("UPDATE passwords SET username='$username',encrypted_password=aes_encrypt('$password', 'ksand3102'),url='$url',description='$description',comments='$comments',date_updated = now() WHERE id='$id'");
					$invalid = FALSE;
				}
			


		//$query = $this->db->query("UPDATE passwords SET username='hello' WHERE id = '$id'");
		//print_r($query->result());
			//

		redirect($redirect_url);
	}

		$this->load->view('edit-password');
		if(isset($invalid)&&$invalid==true){
			echo '<script language="javascript">
					alert("Input valid url!");
					</script>';
		}
	}
	
	public function delete_password()
	{
		$this->load->helper('url');
		
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$client_id = $_GET['client_id'];
			$this->db->delete('passwords', array('id' => $id));
			//$sql = mysql_query("DELETE FROM passwords WHERE id='$id'");
			$redirect_url = '/passwords?client=' . $client_id . '';
			redirect($redirect_url);
			
			
		}
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
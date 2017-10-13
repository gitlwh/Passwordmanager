<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	public $users;
	public $user;
	public $message = false;
	
	public function __construct() {
		parent::__construct();
		//Load up some tools
		$this->load->helper(array('url'));
		$this->load->library('session');
		$this->load->database();
		
		//Verify logged in
		if(!$this->session->userdata('logged_in')) {
			redirect('/home/login/');
		}
	}
	
	public function index() {		
		//Save post
		if(isset($_POST['username']) && isset($_POST['name'])) {
			$password = false;
			if(isset($_POST['password']) && isset($_POST['conf_password']) && !empty($_POST['password'])) {
				if($_POST['password'] == $_POST['conf_password']) {
					$password = $this->format_password($_POST['password']);
				} else {
					$this->message = 'Passwords do not match.';
				}
			}
			$username = $this->mysqlstringformat($_POST['username']);
			$fullname = $this->mysqlstringformat($_POST['name']);
			
			//Check if its an edit
			if(isset($_POST['id']) && !empty($_POST['id'])) {
				//Edit User
				$id = $this->mysqlstringformat($_POST['id']);

				$query = $this->db->get_where('users', array('username' => $username,'id !='=>$id));
			if(sizeof($query->result())!=0){
				$this->message ="duplicated username!";
			}else{




				$sql = 'UPDATE `users` SET `username` = \''.$username.'\', `fullname` = \''.$fullname.'\''.(($password) ? ', `password` = \''.$password.'\'':'').' WHERE `id` = '.$id;}
			} else {

				$query = $this->db->get_where('users', array('username' => $username));
			if(sizeof($query->result())!=0){
				$this->message ="duplicated username!";
			}else{
				//Add New
				if($password) {

					$sql = "INSERT INTO users (username,fullname,password,role_id) VALUES ('$username','$fullname','$password','0')";
				}}
			}
			//print_r($sql);
			if(!$this->message && $this->db->query($sql)) {
				$this->message = 'User added/updated successfully.';
			} elseif(!$this->message) {
				$this->message = 'There was and error writing to the database.';
			}
		}
		
		//Get all users
		$query = $this->db->query('SELECT * FROM `users` ORDER BY `fullname`');
		if($query->num_rows() > 0) {
			$this->users = $query->result();	
		}
		
		//Must be editing so pull user info
		if(isset($_GET['user']) && !empty($_GET['user'])) {
			$query = $this->db->query('SELECT * FROM `users` WHERE id = '.$this->mysqlstringformat($_GET['user']));
			$this->user = $query->row();
		}		
		
		$this->load->view('users',$this);
	}
	
	public function delete() {
		if(isset($_GET['user']) && !empty($_GET['user'])) {
			$this->db->query('DELETE FROM `users` WHERE id = '.$this->mysqlstringformat($_GET['user']).' LIMIT 1');
		}
		header('Location: /index.php/users/');
		exit;
	}
	
	public function format_password($pw) {
		return md5($pw);
	}
	
	public function mysqlstringformat($string) {

		$new_name = $this->db->escape_str($string);
		//return function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($string) : mysqli_escape_string($string);
		return $new_name;
	}
	
}
?>
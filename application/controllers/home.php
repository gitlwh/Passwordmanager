<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->helper('form');
		$this->load->view('login');
	}
	
	public function login() {
		//Load the form helper and form_validation library
	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
	
		//Set rules for username and password validation.
	  $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
	  $this->form_validation->set_rules('password', 'Password', 'required|callback_password_check');
	
		//If there are errors, display the login form again with errors. If no errors, set session variables and redirect to dashboard.
  	if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login');
		}
		elseif ($this->form_validation->run() == TRUE)
		{
			//Get the username from the login form submission
			$user = $_POST['username'];
			
			//Get the user id from the database
			//$sql = mysql_query("SELECT id FROM users WHERE username='$user'");

			$sql = $this->db->select("id");
			$username_query = $this->db->get_where('users', array('username' => $user));

			foreach ($username_query->result() as $row)
			{	
				//print_r($row);
				$id = $row->id;
			}
			
		
			//Set session variables
			$this->session->set_userdata('username', $user);
			$this->session->set_userdata('user_id', $id);
			$this->session->set_userdata('logged_in', TRUE);
			
			//Redirect to the dashboard
			redirect('/passwords');
		}
	}
	
	public function logout() {
		$this->load->helper(array('url'));
		
		//unSet session variables
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('logged_in');
		
		//Redirect to home page for login
		redirect('/home/login/');
	}
	
	public function username_check($str)
  {
		//Check if the username exists. If it does not, alert the user and return false. If it does exist, return true.
  	$this->db->select('username');
  	$username_query = $this->db->get_where('users', array('username' => $str));
    //$username_query = mysqli_query("SELECT username FROM users WHERE username = '$str'");
    foreach ($username_query->result() as $row)
{
		//print_r($row->username);
        //echo $row->title;
        return true;
}
      $this->form_validation->set_message('username_check', 'The username ' . $str . ' does not exist. Have you <a href="#">forgotten your username?</a>');
      return FALSE;
  }

	public function password_check($str)
  {
		//Encrypt the entered password
		$encrypted_pass = md5($str);
		
		//Get the username from the form submission
		$username = $_POST['username'];
		
		//Check if the username and password match in the database. If they do not, alert the user and return false. If they do match, return true.
	$sql = $this->db->select("username,password");
	//print_r($str);
	//print_r($encrypted_pass);
	$username_query = $this->db->get_where('users', array('username' => $_POST['username'],'password'=>$encrypted_pass));
    //$sql = mysqli_query("SELECT username, password FROM users WHERE username = '$username' AND password = '$encrypted_pass'");
    foreach ($username_query->result() as $row)
{
		//print_r($row->password);
        //echo $row->title;
        return true;
}
		
      $this->form_validation->set_message('password_check', 'The password you entered does not match the username you entered. Have you <a href="#">forgotten your password?</a>');
      return FALSE;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
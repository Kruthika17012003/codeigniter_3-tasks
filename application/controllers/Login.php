<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login');
    }

    public function validate() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($user = $this->Login_model->validate_user($username, $password)) {
            $session_data = array(
                'user_id' => $user->id,
                'username' => $user->username,
                'logged_in' => TRUE,
                'last_activity' => time()
            );
            // Set session data
            $this->session->set_userdata($session_data);

            // Redirect to user form
            echo json_encode(['status' => 'success']);
        } else {
            // Invalid login credentials
            echo json_encode(['status' => 'error', 'message' => 'Invalid Username or Password']);
        }
    }

	public function login() {
		// Load the model
		$this->load->model('Login_model');
		$this->session->set_userdata('logged_in', TRUE);
        redirect('user_form');
	
		// Get form data
		$username = $this->input->post('username');
		$password = $this->input->post('password');
	
		// Validate input
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, load the login view again
			$this->load->view('login_view');
		} else {
			// Update the users1 table
			$data = array(
				'username' => $username,
				'password' => password_hash($password, PASSWORD_BCRYPT) // Hash the password
			);
	
			// Attempt to update or insert
			if ($this->User_model->update_or_insert_user($data)) {
				// Successful login
				redirect('user_form');
			} else {
				// Log error if database update/insert failed
				log_message('error', 'Failed to update or insert user data');
			}
	}
	
}
public function logout() {
	// Destroy session on logout
	$this->session->sess_destroy();
	redirect('login');
}
}
?>

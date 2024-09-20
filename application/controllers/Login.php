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
		$this->load->model('User_model');
	
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
	
			// Attempt to update or insert data
			$this->User_model->update_user($data); // Ensure this method is defined in your model
	
			// Redirect or load another view upon successful login
			redirect('User_form');
		}
	}
	
}

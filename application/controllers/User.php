<?php
// application/controllers/User.php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model'); // Load the User model
		$this->load->model('Group_model'); //Load the Group model
		// $this->load->library('input'); // Load input library (optional as it's loaded by default)
    }

    public function index() {
        $data['groups'] = $this->Group_model->get_groups(); // Fetch groups from the model
		// print_r($data);exit;// to check whether groups data is fetched or not by terminating the program here
		$data['users'] = $this->User_model->get_users();
        // $this->load->view('user_form', $data); // Pass groups to the view
		$this->load->view('user_form',$data);
		// echo json_encode($data);
    }

    public function submit() {
		$data = array(
			'UserID' => $this->input->post('UserID'),
			'Name' => $this->input->post('Name'),
			'phoneNumber' => $this->input->post('phoneNumber'),
			'group_id' => $this->input->post('group')
		);
		
		// Attempt to insert user data
		$result = $this->User_model->insert_user($data);
		
		if ($result) {
			// On success, fetch updated users and send JSON response
			$users = $this->User_model->get_users($result); // Retrieve updated user list
			$response = array(
				'status' => 'success',
				'message' => 'Data successfully inserted.',
				'users' => $users
			);
		} else {
			// On failure, send error response
			$response = array(
				'status' => 'error',
				'message' => 'Failed to insert data into the database.'
			);
		}
		
		// Output JSON response
		echo json_encode($response);
	}

    public function display() {
        $data['users'] = $this->User_model->get_users(); // Fetch users from the model
        $this->load->view('user_table', $data); // Pass users to the view
    }

    public function groups() {
        $data['groups'] = $this->Group_model->get_groups(); // Fetch groups if needed
        $this->load->view('groups', $data); // Pass groups to the view
		echo json_encode($data);
    }

	public function delete_user($id) {
	
		// Soft delete by updating the status to 0
		$result = $this->User_model->soft_delete_user($id);
	
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
		}
	}
	
	public function soft_delete_user($id) {
        // Set status to 0 for soft delete
        $this->db->set('status', 0);
        $this->db->where('id', $id);
        return $this->db->update('users'); // Return true/false based on success
    }

	private function session_timeout_check() {
        $session_expiry_time = 3; // Set the session timeout for 3 seconds

        if ($this->session->userdata('last_activity')) {
            // Calculate the time since the last activity
            $time_inactive = time() - $this->session->userdata('last_activity');

            // Check if the session is expired
            if ($time_inactive > $session_expiry_time) {
                // Destroy the session and redirect to login page
                $this->session->sess_destroy();
                redirect('login');
            } else {
                // Update the last activity time
                $this->session->set_userdata('last_activity', time());
            }
        }
    }
	public function user_form() {
		if (!$this->session->userdata('logged_in')) {
			redirect('login'); // Redirect to login if session expired
		}
		// Load the user form view
		$this->load->view('user_form');
	}
	

}
?>


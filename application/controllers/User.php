<?php
// application/controllers/User.php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model1'); // Load the User model
		$this->load->model('Group_model'); //Load the Group model
		// $this->load->library('input'); // Load input library (optional as it's loaded by default)
    }

    public function index() {
        $data['groups'] = $this->Group_model->get_groups(); // Fetch groups from the model
		// print_r($data);exit;// to check whether groups data is fetched or not by terminating the program here
		$data['users'] = $this->User_model1->get_users();
        // $this->load->view('user_form', $data); // Pass groups to the view

		echo json_encode($data);
    }

    public function submit() {
		$data = array(
			'UserID' => $this->input->post('UserID'),
			'Name' => $this->input->post('Name'),
			'phoneNumber' => $this->input->post('phoneNumber'),
			'group_id' => $this->input->post('group')
		);
		
		// Attempt to insert user data
		$result = $this->User_model1->insert_user($data);
		
		if ($result) {
			// On success, fetch updated users and send JSON response
			$users = $this->User_model1->get_users($result); // Retrieve updated user list
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
        $data['users'] = $this->User_model1->get_users(); // Fetch users from the model
        $this->load->view('user_table', $data); // Pass users to the view
    }

    public function groups() {
        $data['groups'] = $this->Group_model->get_groups(); // Fetch groups if needed
        $this->load->view('groups', $data); // Pass groups to the view
		echo json_encode($data);
    }

}
?>


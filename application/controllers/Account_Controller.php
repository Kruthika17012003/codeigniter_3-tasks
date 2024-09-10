<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the database library
        $this->load->database();
        // Load the form validation library
        $this->load->library('form_validation');
    }

    public function create_user() {
        // Set form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email_id', 'Email ID', 'required|valid_email|is_unique[user_details.email_id]');

        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 'error',
                'message' => validation_errors()
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        // Get data from POST request
        $name = $this->input->post('name');
        $email_id = $this->input->post('email_id');

        // Insert data into the user_details table
        $data = [
            'name' => $name,
            'email_id' => $email_id
        ];

        $this->db->insert('user_details', $data);

        // Update email_repeated table
        $this->update_email_repeated($email_id);

        // Get the total number of users
        $user_count = $this->db->count_all('user_details');

        // Get details of repeated email_ids
        $this->db->select('email_id, repeat_count');
        $repeated_emails = $this->db->get('email_repeated')->result_array();

        $response = [
            'status' => 'success',
            'message' => 'User created successfully',
            'user_count' => $user_count,
            'repeated_emails' => $repeated_emails
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function update_email_repeated($email_id) {
        // Check if the email_id already exists in the email_repeated table
        $this->db->where('email_id', $email_id);
        $query = $this->db->get('email_repeated');

        if ($query->num_rows() > 0) {
            // Update existing record
            $row = $query->row();
            $repeat_count = $row->repeat_count + 1;
            $this->db->where('email_id', $email_id);
            $this->db->update('email_repeated', ['repeat_count' => $repeat_count]);
        } else {
            // Insert new record
            $this->db->insert('email_repeated', ['email_id' => $email_id, 'repeat_count' => 1]);
        }
    }
}

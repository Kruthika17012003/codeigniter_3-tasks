<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model {

    // Insert a new user into user_details
    public function insert_user($name, $email) {
        $data = [
            'name' => $name,
            'email_id' => $email
        ];

        // Check for email uniqueness before insert
        if ($this->db->insert('user_details', $data)) {
            return true;
        } else {
            return false; // Email is not unique (duplicate)
        }
    }

    // Increment email count if duplicate is found
    public function increment_email_count($email) {
        // Check if the email already exists in the email_repeated
        $this->db->where('email_id', $email);
        $query = $this->db->get('email_repeated');

        if ($query->num_rows() > 0) {
            // If email already exists, increment the count
            $this->db->set('count', 'count+1', FALSE);
            $this->db->where('email_id', $email);
            $this->db->update('email_repeated');
        } else {
            // Insert new email with count = 1
            $this->db->insert('email_repeated', ['email_id' => $email, 'count' => 1]);
        }
    }

    // Get the total number of unique users
    public function get_user_count() {
        return $this->db->count_all('user_details');
    }

    // Get repeated email details
    public function get_repeated_emails() {
        $this->db->select('email_id, count');
        $query = $this->db->get('email_repeated');
        return $query->result_array();
    }
}

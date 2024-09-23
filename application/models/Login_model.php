<?php
class Login_model extends CI_Model {

	public function __construct() {
        $this->load->database();
    }

public function validate_user($username, $password) {
	// Ensure the table is 'users1'
	$this->db->where('username', $username);
	$this->db->where('password', md5($password)); // Assuming passwords are stored as md5
	$query = $this->db->get('users1'); // Make sure you're querying the 'users1' table

	if ($query->num_rows() == 1) {
		return $query->row(); // Return the user object if login is valid
	}

	return false;
}


public function update_user($data) {
    $this->db->where('username', $data['username']);
    $this->db->update('users1', $data);
    
    // Log the last executed query
    log_message('debug', $this->db->last_query());
    
    return $this->db->affected_rows() > 0;  // Check if rows were updated
}


public function update_last_login($user_id) {
	// Update the last_login time for the user in 'users1'
	$data = array(
		'last_login' => date('Y-m-d H:i:s') // Update login time
	);
	$this->db->where('id', $user_id);
	return $this->db->update('users1', $data); // Update the table 'users1'
}
}
?>

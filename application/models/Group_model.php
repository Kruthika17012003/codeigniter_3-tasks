<?php
class Group_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_groups() {
        $query = $this->db->get('groups');
        return $query->result_array(); // Returns an associative array of groups
    }
}
?>

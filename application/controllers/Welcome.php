<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function user_form()
	{
		$this->load->view('user_form');
	}
	
	public function groups()
	{
		$this->load->view('groups');
	}

	public function Display()
	{
		$this->load->view('Display');
	}
	
    
	// public function __construct() {
    //     parent::__construct();
    //     $this->load->database(); // Load the database library
    }

    // public function User_model() {
    //     $query = $this->db->get('users');
    //     $data['users'] = $query->result_array();
    //     $this->load->view('User_model', $data);
    // }
	
	
// }

?>

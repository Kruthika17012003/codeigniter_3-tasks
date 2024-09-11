<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

    public function submit_form() {
        // Load form helper if needed
        $this->load->helper('form');

        // Get POST data
        $name = $this->input->post('name');
        $email = $this->input->post('email');

        // Process form data (e.g., save to database or send email)
        // For this example, we'll just return a success message
        if ($name && $email) {
            echo "Form submitted successfully. Name: $name, Email: $email";
        } else {
            echo "Form submission failed. Please try again.";
        }
    }
}

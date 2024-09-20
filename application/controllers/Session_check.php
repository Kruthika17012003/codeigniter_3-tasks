<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_check extends CI_Controller {

    public function index() {
        // Start the session
        session_start();

        // Check if the session variable is set
        if (!isset($_SESSION['logged_in'])) {
            $_SESSION['logged_in'] = true;
            echo 'Session started.<br>';
        } else {
            echo 'Session active. Expiring in 3 seconds...<br>';
            sleep(3); // Simulate wait
            session_destroy();
            echo 'Session destroyed.';
        }
    }
}

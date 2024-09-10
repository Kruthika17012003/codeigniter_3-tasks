<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database
        $this->load->helper(array('url', 'file')); // Load helpers for URL and file
    }

    // Function to handle CSV file upload and processing
    public function uploadCSV() {
		// Set the response format to JSON
		header('Content-Type: application/json');
	
		// Check if the file is uploaded
		if (isset($_FILES['userDetails']['name'])) {
			// Check for upload errors
			if ($_FILES['userDetails']['error'] != 0) {
				echo json_encode(['status' => false, 'message' => 'File upload error: ' . $_FILES['userDetails']['error']]);
				return;
			}
	
			$filePath = $_FILES['userDetails']['tmp_name'];
	
			// Check if the file is readable
			if (($handle = fopen($filePath, 'r')) !== FALSE) {
				$csvData = [];
	
				// Read the CSV file row by row
				while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
					$csvData[] = $row;
				}
				fclose($handle);
	
				// Process the CSV data
				$response = $this->processCSV($csvData);
	
				// Return response in JSON format
				echo json_encode($response);
			} else {
				echo json_encode(['status' => false, 'message' => 'Unable to read the file']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'No file uploaded']);
		}
	}
	

    // Function to process the CSV data and insert/update records
    private function processCSV($csvData) {
        $inserted_users = 0;
        $repeated_emails = [];

        // Skip the first row if it contains headers
        array_shift($csvData);

        foreach ($csvData as $row) {
            $name = $row[0];
            $email_id = $row[1];

            if (!empty($name) && !empty($email_id)) {
                // Check if email already exists in user_details
                $query = $this->db->get_where('user_details', ['email_id' => $email_id]);

                if ($query->num_rows() == 0) {
                    // Insert unique email into user_details
                    $this->db->insert('user_details', ['name' => $name, 'email_id' => $email_id]);
                    $inserted_users++;
                } else {
                    // Email exists, increment the count in email_repeated table
                    $email_check = $this->db->get_where('email_repeated', ['email_id' => $email_id]);

                    if ($email_check->num_rows() > 0) {
                        // Email already in email_repeated, update the count
                        $this->db->set('count', 'count + 1', FALSE)
                            ->where('email_id', $email_id)
                            ->update('email_repeated');
                    } else {
                        // Insert the repeated email into email_repeated
                        $this->db->insert('email_repeated', ['email_id' => $email_id, 'count' => 2]);
                    }
                    $repeated_emails[] = $email_id;
                }
            }
        }

        // Prepare the response
        $response = [
            'status' => true,
            'message' => 'CSV file processed successfully',
            'inserted_users' => $inserted_users,
            'repeated_emails' => $this->getRepeatedEmails(),
        ];

        return $response;
    }

    // Function to fetch repeated emails with count
    private function getRepeatedEmails() {
        return $this->db->select('email_id, count')
                        ->from('email_repeated')
                        ->get()
                        ->result_array();
    }
}

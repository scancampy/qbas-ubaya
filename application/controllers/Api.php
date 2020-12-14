<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Api extends CI_Controller {
	public function signin() {
		if($this->input->post('snrp') && $this->input->post('pin')) {
			$result = $this->student_model->doSignIn($this->input->post('snrp'), $this->input->post('pin'));

			if($result == false) {
				echo json_encode(array('result'=> false));
			} else {
				echo json_encode(array('result' => true, 'nrp' => $result->nrp));
			}
		} else {
			echo json_encode(array('result'=> false));
		}
	}

}

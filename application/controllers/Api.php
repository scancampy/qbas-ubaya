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

	public function getserverdate() {
		echo json_encode(array('serverdate' => strftime("%A, %d %B %Y", strtotime("now"))));
	}

	public function getstudent() {
		if($this->input->post('nrp')) {
			$result = $this->student_model->getStudent($this->input->post('nrp'));

			if($result == false) {
				echo json_encode(array('result'=> false));
			} else {
				echo json_encode(array('result' => true, 'data' => $result ));
			}
		} else {
			echo json_encode(array('result'=> false));
		}
	}

	public function getupcoming() {
		if($this->input->post('nrp')) {
			$result = $this->attendances_model->checkAttendances($this->input->post('nrp'));
			if($result == false) {
				echo json_encode(array('result'=> false));
			} else {
				echo json_encode(array('result' => true, 'data' => $result));
			}
		} else {
			echo json_encode(array('result'=> false));
		}
	}

	public function getcurrentclass() {
		if($this->input->post('nrp')) {
			$result = $this->attendances_model->getCurrentClass($this->input->post('nrp'));
			if($result == false) {
				echo json_encode(array('result'=> false));
			} else {
				$absence = $this->attendances_model->getAbsenceCurrentClass($this->input->post('nrp'));
				echo json_encode(array('result' => true, 'data' => $result, 'absence' => $absence ));
			}
		} else {
			echo json_encode(array('result'=> false));
		}
	}

	public function checkqr() {
		//echo json_encode(array('result'=> false));

		if($this->input->post('qr')) {
			$result = $this->attendances_model->checkQR($this->input->post('nrp'), $this->input->post('qr'));
			if($result == false) {
				echo json_encode(array('result'=> false));
			} else {
				echo json_encode(array('result' => true ));
			}
		} else {
			echo json_encode(array('result'=> false));
		}
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate_model extends CI_Model {

	public function getLogs() {
		$result = $this->db->get('log_generate_absence');
		return $result->result();
	}

	public function generate($active_semester_id) {
		// get all course open within semester active
		$q = $this->db->get_where('course_open', array('semester_id' => $active_semester_id));
		$total =0;
		foreach ($q->result() as $key => $value) {
			$p = $this->db->get_where('schedule', array('course_open_id' => $value->id));
			foreach ($p->result() as $key2 => $value2) {
				$l = $this->db->get_where('student_course', array('course_open_id'=> $value->id));
				foreach ($l->result() as $key3 => $value3) {
					$m = $this->db->get_where('absence', array('student_nrp' => $value3->student_nrp, 'course_open_id' => $value->id, 'schedule_id' => $value2->id));

					if($m->num_rows() == 0) {
						$data = array(
							'student_nrp' => $value3->student_nrp,
							'course_open_id' => $value->id,
							'schedule_id' => $value2->id,
							'absence_date' => null,
							'qr_code' => null,
							'authenticator_code' => null,
						    'authenticator_expired' => null,
						    'is_absence' => 0
						);
						$this->db->insert('absence', $data);
						$total++;
					}
				}
			}
		}

		if($total ==0) {
			$datalog = array('generate_date' => date('Y-m-d H:i:s'), 'logs' => 'Zero absence generated');
			$this->db->insert('log_generate_absence', $datalog);
		} else {
			$datalog = array('generate_date' => date('Y-m-d H:i:s'), 'logs' => $total.' absence generated');
			$this->db->insert('log_generate_absence', $datalog);
		}
	}
}
?>
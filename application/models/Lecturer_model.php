<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecturer_model extends CI_Model {

	public function getStudent($npk) {
		$result = $this->db->get_where('lecturer', array('npk' => $npk));
		if($result->num_rows() >0) {
			return $result->row();
		} else {
			return false;
		}
	}

	public function upcomingClass($npk) {
		$active = $this->db->get_where('semester', array('is_active' => 1));
		$hactive = $active->row();

		$res = $this->db->query('SELECT course.*, course_open.id as `course_open_id` FROM course, lecturer_course_open, course_open WHERE lecturer_course_open.lecturer_npk = "'.$npk.'" AND lecturer_course_open.course_open_id = course_open.id AND course_open.semester_id  = 1 AND course_open.course_id = course.course_id;');

		if($res->num_rows() > 0) {
			$schedule = array();
			foreach ($res->result() as $key => $value) {
				//$schedule[$key]['course'] = $value;
				$this->db->order_by('start_date', 'asc');
				$sch = $this->db->get_where('schedule', array('course_open_id' => $value->course_open_id, 'start_date >= ' => date('Y-m-d H:i:s')));

				if($sch->num_rows() >0) {

					foreach ($sch->result() as $key2 => $value2) {
						$schedule[] = array('course_open_id' => $value->course_open_id,
									'course_id' => $value->course_id,
									'course_name' => $value->course_name,
									'methods' => $value2->methods,
									'kp' => $value->KP,
									'id' => $value2->id,
									'start_date' => $value2->start_date,
									'start_date_format' => strftime("%A, %d %B %Y", strtotime($value2->start_date)),
									'end_date' => $value2->end_date
									);
					}
				}
			}

			$new = array_multisort(array_map('strtotime',array_column($schedule,'start_date')),
                SORT_ASC, $schedule);
			//print_r($schedule);
			return $schedule;
		} else {
			return false;
		}
	}

	public function doSignIn($npk, $password) {
		$res = $this->db->get_where('lecturer', array('npk' => $npk));

		if($res->num_rows() > 0) {
			$hres = $res->row();
			if(password_verify($password, $hres->password)) {
				return $hres;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}
?>
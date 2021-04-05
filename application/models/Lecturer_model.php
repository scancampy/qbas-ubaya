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

	public function getLecturer($npk = null, $where = null) {
		if($nrp != null) {
			$this->db->where('npk', $nrp);
		}
		if($where != null) {
			$this->db->where($where);
		}

		$result = $this->db->get('lecturer');
		return $result->result();
	}

	public function addLecturer($npk, $full_name) {
		$q = $this->db->get_where('lecturer', array('npk' => $npk));

		if($q->num_rows() == 0) {
			$data = array('npk' => $npk, 'full_name' => $full_name);
			$this->db->insert('lecturer', $data);
			return 'success';
		} else {
			return 'npk exists';
		}
	}


	public function editLecturer($npk,$full_name) {
		$data = array('full_name' => $full_name);
		$this->db->where('npk', $npk);
		$this->db->update('lecturer', $data);
	}

	public function delLecturer($npk) {
		$this->db->where('npk', $npk);
		$this->db->update('lecturer', array('is_deleted' => 1));
	}

	public function getCurrentClass($npk) {
		$active = $this->db->get_where('semester', array('is_active' => 1));
		$hactive = $active->row();

		$res = $this->db->query('SELECT course.*, course_open.id as `course_open_id`, course_open.KP FROM course, lecturer_course_open, course_open WHERE lecturer_course_open.lecturer_npk = "'.$npk.'" AND lecturer_course_open.course_open_id = course_open.id AND course_open.semester_id  = '.$hactive->id.' AND course_open.course_id = course.course_id;');

		if($res->num_rows() > 0) {
			$schedule = array();
			foreach ($res->result() as $key => $value) {
				//$schedule[$key]['course'] = $value;
				$this->db->order_by('start_date', 'asc');
				$sch = $this->db->query('SELECT * FROM `schedule` WHERE course_open_id ='.$value->course_open_id.' AND UNIX_TIMESTAMP() >= UNIX_TIMESTAMP(start_date)-900 AND UNIX_TIMESTAMP() <= UNIX_TIMESTAMP(end_date)');

				if($sch->num_rows() >0) {
					$value2 = $sch->row();
					$schedule[] = array('course_open_id' => $value->course_open_id,
									'course_id' => $value->course_id,
									'course_name' => $value->course_name,
									'kp' => $value->KP,
									'methods' => $value2->methods,
									'id' => $value2->id,
									'start_date' => $value2->start_date,
									'end_date' => $value2->end_date
									);
				}
			}

			return $schedule;
		} else {
			return false;
		}
	}

	public function requestQR($schedule_id) {
		$res = $this->db->get_where('schedule', array('id' => $schedule_id));

		if($res->num_rows() >0) {
			$hres = $res->row();

			if(time() > strtotime($hres->class_code_expired)  ) {
				// update qr
				$hash = password_hash(date('Y-m-d H:i:s').$schedule_id, PASSWORD_DEFAULT);
				$data = array('class_code' => $hash, 
					'class_code_expired' => strftime("%Y-%m-%d %H:%M:%S", time() + 10));

				$this->db->where('id', $hres->id);
				$this->db->update('schedule', $data);
				return $hash;
			} else {
				return $hres->class_code;
			}
		} else {
			return false;
		}
	}

	public function upcomingClass($npk) {
		$active = $this->db->get_where('semester', array('is_active' => 1));
		$hactive = $active->row();

		$res = $this->db->query('SELECT course.*, course_open.id as `course_open_id`, course_open.KP FROM course, lecturer_course_open, course_open WHERE lecturer_course_open.lecturer_npk = "'.$npk.'" AND lecturer_course_open.course_open_id = course_open.id AND course_open.semester_id  = '.$hactive->id.' AND course_open.course_id = course.course_id;');

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
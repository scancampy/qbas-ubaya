<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendances_model extends CI_Model {

	public function requestQR($nrp, $course_open_id, $schedule_id) {
		$res = $this->db->get_where('absence', array('student_nrp' => $nrp, 'course_open_id' => $course_open_id, 'schedule_id' => $schedule_id));

		if($res->num_rows() >0) {
			$hres = $res->row();
			// update qr
			$hash = password_hash(date('Y-m-d H:i:s').$nrp, PASSWORD_DEFAULT);
			$data = array('qr_code' => $hash);

			$this->db->where('id', $hres->id);
			$this->db->update('absence', $data);

			return $hash;
		} else {
			// create new one
			$hash = password_hash(date('Y-m-d H:i:s').$nrp, PASSWORD_DEFAULT);

			$data = array('student_nrp' => $nrp,
						  'course_open_id' => $course_open_id,
						  'schedule_id' => $schedule_id,
						  'qr_code'	=> $hash
						 );
			$this->db->insert('absence', $data);

			return $data;
		}
	}

	public function requestAuthenticatorCode($nrp) {
		$hasil = $this->getCurrentClass($nrp);

		$cek = '';
		if($hasil == false) {
			return false;
		} else {
			foreach ($hasil as $key => $value) {
				$id = $value['id'];
				$this->db->reset_query();

				$result = $this->db->get_where('absence', array('schedule_id' => $id, 'student_nrp' => $nrp, 'is_absence' => 0));

				if($result->num_rows() >0) {
					$hresult = $result->row();

					if(time() > strtotime($hresult->authenticator_expired)  ) {
						//expired bikin baru
						$this->load->helper('string');
						$newcode =  random_string('numeric', 5);
						$data = array('authenticator_code' => $newcode,
									  'authenticator_expired' => strftime("%Y-%m-%d %H:%M:%S", time() + 10));
						$this->db->where(array('student_nrp' => $nrp, 'schedule_id' => $id));
						$this->db->update('absence', $data);
						$cek = $newcode;
					} else {
						$cek =  $hresult->authenticator_code;
					}
				}
			}
			return $cek;
		}
	}

	public function getCurrentClass($nrp) {
		$active = $this->db->get_where('semester', array('is_active' => 1));
		$hactive = $active->row();

		$res = $this->db->query('SELECT student_course.*, course.*, course_open.KP FROM student_course, course_open,course WHERE course_open.semester_id = 1 AND course_open.id = student_course.course_open_id AND student_course.student_nrp = "'.$nrp.'" AND course.course_id = course_open.course_id;');
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

	public function getAbsenceCurrentClass($nrp) {
		$this->db->reset_query();
		$hasil = $this->getCurrentClass($nrp);
		$cek = false;
		if($hasil == false) {
			return false;
		}  else {

			$data = array();
			foreach ($hasil as $key => $value) {
				$id = $value['id'];
				$this->db->reset_query();

				$result = $this->db->get_where('absence', array('schedule_id' => $id, 'student_nrp' => $nrp, 'is_absence' => 1));

				if($result->num_rows() >0 ) {
					$data[] = true;
				} else {
					$data[] = false;
				}
			}

			return $data;
		}
	}

	public function getStudentAbsence($nrp, $course_id = null) {
		$wherecourse = '';
		if($course_id != null) {
			$wherecourse = " AND course.course_id = '".$course_id."' ";
		}

		$q = $this->db->query("SELECT absence.*, schedule.start_date, course_open.KP, course.course_short_name, course.course_id FROM `absence` 
INNER JOIN schedule ON schedule.id = absence.schedule_id
INNER JOIN course_open ON course_open.id = absence.course_open_id
INNER JOIN course ON course.course_id = course_open.course_id 
WHERE absence.student_nrp = $nrp ".$wherecourse);
		//echo $this->db->last_query(); 

		return $q->result();
	}

	public function checkAuthenticator($nrp, $codes) {
		$hasil = $this->getCurrentClass($nrp);
		//echo $hasil; die();
		$cek = false;
		if($hasil == false) {
			return false;
		} else {
			foreach ($hasil as $key => $value) {
				$id = $value['id'];
				$this->db->reset_query();

				$result = $this->db->get_where('absence', array('schedule_id' => $id, 'student_nrp' => $nrp, 'is_absence' => 0));


				if($result->num_rows() >0) {
					$hresult = $result->row();


					if($hresult->authenticator_code == $codes) {
						$data = array('absence_date' => date('Y-m-d H:i:s'), 'is_absence' => 1);
						$this->db->where('id', $hresult->id);
						$this->db->update('absence', $data);

						$cek = true;
					} else {
						$cek = false;
					}
				}
			}

			return $cek;
		}
	}

	public function buttonattend($nrp) {
		$hasil = $this->getCurrentClass($nrp);

		$cek = false;
		if($hasil == false) {
			return false;
		} else {
			foreach ($hasil as $key => $value) {
				$id = $value['id'];
				$this->db->reset_query();

				$result = $this->db->get_where('absence', array('schedule_id' => $id, 'student_nrp' => $nrp, 'is_absence' => 0));

				if($result->num_rows() >0) {
					$hresult = $result->row();

					$data = array('absence_date' => date('Y-m-d H:i:s'), 'is_absence' => 1);
					$this->db->where('id', $hresult->id);
					$this->db->update('absence', $data);

					$cek = true;
				}
			}

			return $cek;
		}
	}


	public function checkQR($nrp, $qr) {
		$hasil = $this->getCurrentClass($nrp);

		$cek = false;
		if($hasil == false) {
			return false;
		} else {
			foreach ($hasil as $key => $value) {
				$id = $value['id'];
				$this->db->reset_query();

				if($value['methods'] == 'manual') {
					$result = $this->db->get_where('schedule', array('id' => $id, 'class_code' => $qr));

					if($result->num_rows() >0) {
						$hresult = $result->row();

						$data = array('absence_date' => date('Y-m-d H:i:s'), 'is_absence' => 1);
						$this->db->where('schedule_id', $id);
						$this->db->where('student_nrp', $nrp);
						$this->db->update('absence', $data);

						$cek = true;
					}

				} else if($value['methods'] == 'auto') {
					$result = $this->db->get_where('absence', array('schedule_id' => $id, 'student_nrp' => $nrp, 'qr_code' => $qr));
					//echo $this->db->last_query();

					if($result->num_rows() >0) {
						$hresult = $result->row();

						$data = array('absence_date' => date('Y-m-d H:i:s'), 'is_absence' => 1);
						$this->db->where('id', $hresult->id);
						$this->db->update('absence', $data);

						$cek = true;
					}
				}				
			}

			return $cek;
		}
	}

	public function getAttendances($course_open_id, $schedule_id) {
		$q = $this->db->query("SELECT student.nrp, student.full_name, absence.absence_date, absence.is_absence FROM absence 
			INNER JOIN student ON student.nrp = absence.student_nrp WHERE absence.course_open_id = $course_open_id AND absence.schedule_id = $schedule_id ORDER BY student.nrp ASC;");
		return $q->result();
	}

	public function checkAttendances($nrp) {
		/*for($i = 0; $i< 14; $i++) {
			$date = date('Y-m-d H:i:s', strtotime(sprintf("+%d weeks", $i)));
			$enddate = date('Y-m-d H:i:s', strtotime('+3 hours',strtotime(sprintf("+%d weeks", $i))));

			$data = array('id' => '', 'course_open_id' => 12, 'start_date' => $date, 'end_date' => $enddate);
			$this->db->insert('schedule', $data);
		}*/

		$active = $this->db->get_where('semester', array('is_active' => 1));
		$hactive = $active->row();

		$res = $this->db->query('SELECT student_course.*, course.*, course_open.KP FROM student_course, course_open,course WHERE course_open.semester_id = 1 AND course_open.id = student_course.course_open_id AND student_course.student_nrp = "'.$nrp.'" AND course.course_id = course_open.course_id;');
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

	public function overrideAttendaces($student_nrp, $course_open_id, $schedule_id) {
		$q = $this->db->get_where('absence', array('student_nrp' => $student_nrp, 'course_open_id' => $course_open_id, 'schedule_id' => $schedule_id));
		if($q->num_rows() > 0) {
			$hq = $q->row();
			if($hq->is_absence == 0) {
				$data = array('absence_date' => date('Y-m-d H:i:s'), 'is_absence' => 1);
				$this->db->where('id', $hq->id);
				$this->db->update('absence', $data);
			}
		} 

	}

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {
	public function getSchedule($id =null, $course_open_id =null, $where = null, $order_by = 'start_date', $order_type='asc') {
		if($id != null) {
			$this->db->where('id', $id);
		}

		if($course_open_id != null) {
			$this->db->where('course_open_id', $course_open_id);
		}

		if($where != null) {
			$this->db->where($where);
		}

		$this->db->order_by($order_by,$order_type);
		$q = $this->db->get('schedule');
		return $q->result();
	}
	
	public function updateschedule($id, $start_date, $end_date, $methods) {
		$data = array(
					  'start_date' => $start_date,
					  'end_date' => $end_date, 
					  'methods' => $methods);
		$this->db->where('id', $id);

		$this->db->update('schedule', $data);
	}

	public function updateScheduleTopic($id, $topic) {
		$data = array('topics' => $topic);
		$this->db->where('id', $id);
		$this->db->update('schedule', $data);
	}

	public function updatemethod($id, $methods) {
		$data = array(  'methods' => $methods);
		$this->db->where('id', $id);

		$this->db->update('schedule', $data);
		return $this->db->last_query();
	}

	public function deleteschedule($id) {
		$this->db->where('id', $id);
		$this->db->delete('schedule');
	}

	public function setSchedule($course_open_id, $start_date, $end_date, $methods) {
		$data = array('course_open_id' => $course_open_id,
					  'start_date' => $start_date,
					  'end_date' => $end_date, 
					  'methods' => $methods);

		$this->db->insert('schedule', $data);
	}

	public function getUpcomingSchedule($nrp, $course_id = null) {
		
		$q = $this->db->query("SELECT `schedule`.*, `course_open`.`KP`, `course_open`.course_id, `course`.`course_name`,  DATE_FORMAT(`schedule`.start_date, '%a, %d %b %Y - %H:%i') as `start_date_formatted`, `course`.`course_short_name` FROM `schedule` INNER JOIN course_open ON course_open.id = `schedule`.`course_open_id` INNER JOIN course ON course.course_id = course_open.course_id INNER JOIN student_course ON student_course.course_open_id = course_open.id WHERE `schedule`.`start_date` >= NOW() AND student_course.student_nrp = '".$nrp."'");

		return $q->result();

	}
}
?> 
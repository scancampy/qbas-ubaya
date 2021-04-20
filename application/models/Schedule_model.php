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
}
?> 
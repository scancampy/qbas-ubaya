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
	
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semester_model extends CI_Model {

	public function getSemester($id = null, $where = null) {

		if($id != null) {
			$this->db->where('id', $id);
		}
		if($where != null) {
			$this->db->where($where);
		}
		$result = $this->db->get('semester');
		return $result->result();
	}

	public function addSemester($semester_name, $is_active) {
		if($is_active == 1) {
			$data = array('is_active' => 0);
			$this->db->update('semester', $data);
		}

		$data = array('semester_name' => $semester_name, 'is_active' => $is_active);
		$this->db->insert('semester', $data);
	}


	public function editSemester($id, $semester_name, $is_active) {
		if($is_active == 1) {
			$data = array('is_active' => 0);
			$this->db->update('semester', $data);
		}

		$data = array('semester_name' => $semester_name, 'is_active' => $is_active);
		$this->db->where('id', $id);
		$this->db->update('semester', $data);
	}

	public function delSemester($id) {
		$this->db->where('id', $id);
		$this->db->update('semester', array('is_deleted' => 1));
	}
}
?>
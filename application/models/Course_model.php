<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

	public function getStudentList($course_open_id) {
		$q = $this->db->query("SELECT student.nrp, student.full_name FROM student_course INNER JOIN student ON student.nrp = student_course.student_nrp WHERE student_course.course_open_id = $course_open_id");

		return $q->result();
	}

	public function getCourse($course_id = null, $where = null) {

		if($id != null) {
			$this->db->where('course_id', $id);
		}
		if($where != null) {
			$this->db->where($where);
		}
		$this->db->order_by('course_name', 'asc');
		$result = $this->db->get('course');
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
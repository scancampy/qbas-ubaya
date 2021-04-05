<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

	public function getStudentList($course_open_id) {
		$q = $this->db->query("SELECT student.nrp, student.full_name FROM student_course INNER JOIN student ON student.nrp = student_course.student_nrp WHERE student_course.course_open_id = $course_open_id");

		return $q->result();
	}

	public function getCourse($course_id = null, $where = null) {

		if($course_id != null) {
			$this->db->where('course_id', $course_id);
		}
		if($where != null) {
			$this->db->where($where);
		}
		$this->db->order_by('course_name', 'asc');
		$result = $this->db->get('course');
		return $result->result();
	}

	public function addCourse($course_id, $course_name, $course_short_name) {
		// cek course id
		$q = $this->db->get_where('course', array('course_id' => $course_id));

		if($q->num_rows() == 0) {
			$data = array('course_id' => $course_id, 'course_name' => $course_name, 'course_short_name' => $course_short_name);
			$this->db->insert('course', $data);
			return 'success';
		} else {
			return 'course_id exists';
		}
	}


	public function editCourse($course_id,$course_name, $course_short_name) {
		$data = array('course_name' => $course_name, 'course_short_name' => $course_short_name);
		$this->db->where('course_id', $course_id);
		$this->db->update('course', $data);
	}

	public function delCourse($course_id) {
		$this->db->where('course_id', $course_id);
		$this->db->update('course', array('is_deleted' => 1));
	}
}
?>
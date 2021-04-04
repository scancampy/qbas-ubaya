<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

	public function getStudentList($course_open_id) {
		$q = $this->db->query("SELECT student.nrp, student.full_name FROM student_course INNER JOIN student ON student.nrp = student_course.student_nrp WHERE student_course.course_open_id = $course_open_id");

		return $q->result();
	}
}
?>
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

	// COURSE OPEN
	public function getCourseOpen($semester_id, $id = null) {
		if($id != null) {
			$q = $this->db->query("SELECT course.*, course_open.KP, course_open.id FROM course_open 
				INNER JOIN course ON course.course_id = course_open.course_id WHERE course_open.id=$id");
		} else {
			$q = $this->db->query("SELECT course.*, course_open.KP, course_open.id FROM course_open 
				INNER JOIN course ON course.course_id = course_open.course_id WHERE course_open.semester_id=$semester_id");
		}
		return $q->result();
	}

	public function getStudentCourseOpen($semester_id, $student_nrp) {
		$q = $this->db->query("SELECT course.*, course_open.KP, course_open.id FROM course_open 
				INNER JOIN course ON course.course_id = course_open.course_id
				INNER JOIN student_course ON student_course.course_open_id = course_open.id  WHERE course_open.semester_id=$semester_id AND student_course.student_nrp = $student_nrp");

		return $q->result();
	} 

	public function addCourseOpen($semester_id, $course_id, $KP) {
		//cek dulu sudah ada atau belum
		$q = $this->db->get_where('course_open', array('semester_id' => $semester_id, 'course_id'=> $course_id, 'KP' => $KP));
		
		if($q->num_rows() > 0) {
			return false;
		} else {
			$data = array('semester_id' => $semester_id, 'course_id'=> $course_id, 'KP' => $KP);
			$this->db->insert('course_open', $data);
			return true;
		}
 	}

 	public function delCourseOpen($semester_id, $id) {
 		$this->db->where('semester_id', $semester_id);
 		$this->db->where('id', $id);
 		$this->db->delete('course_open');
 	}

 	public function addStudent($nrp, $course_open_id) {
 		$q = $this->db->get_where('student_course', array('student_nrp'=> $nrp, 'course_open_id' => $course_open_id));

 		if($q->num_rows() ==0) {
 			$data =array('student_nrp' => $nrp, 'course_open_id' => $course_open_id);
 			$this->db->insert('student_course', $data);
 			return true;
 		} else {
 			return false;
 		}
 	}

 	public function removeStudent($nrp, $course_open_id) {
 		$this->db->where('student_nrp', $nrp);
 		$this->db->where('course_open_id', $course_open_id);
 		$this->db->delete('student_course');
 	}

 	// LECTURER COURSE OPEN
 	public function getLecturerList($id = null, $course_open_id  = null) {
 		if($id!=null) {
 			$this->db->where('id', $id);
 		}
 		if($course_open_id != null) {
 			$this->db->where('course_open_id', $course_open_id);
 		}
 		$this->db->join('lecturer', 'lecturer.npk = lecturer_course_open.lecturer_npk', 'inner');
 		$this->db->select('lecturer_course_open.*');
 		$this->db->select('lecturer.full_name');
 		$result = $this->db->get('lecturer_course_open');

 		return $result->result();
 	}

 	public function findLecturer($course_open_id, $lecturer_npk) {
 		$q = $this->db->get_where('lecturer_course_open', array('course_open_id' => $course_open_id, 'lecturer_npk' => $lecturer_npk));

 		return $q->result();
 	}

 	public function removeLecturer($course_open_id, $lecturer_npk) {
 		$this->db->where("course_open_id", $course_open_id);
 		$this->db->where("lecturer_npk", $lecturer_npk);
 		$this->db->delete('lecturer_course_open');
 	}

 	public function addLecturer($course_open_id, $lecturer_npk) {
 		$data = array('course_open_id' => $course_open_id, 'lecturer_npk' => $lecturer_npk);
 		$this->db->insert('lecturer_course_open', $data);
 		return true;
 	}


}
?>
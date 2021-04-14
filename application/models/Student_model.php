<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

	public function getStudent($nrp) {
		$result = $this->db->get_where('student', array('nrp' => $nrp));
		if($result->num_rows() >0) {
			return $result->row();
		} else {
			return false;
		}
	}

	public function getStudents($nrp = null, $where = null, $order_by = 'nrp', $order_type='asc') {
		if($nrp != null) {
			$this->db->where('nrp', $nrp);
		}
		if($where != null) {
			$this->db->where($where);
		}

		$this->db->order_by($order_by, $order_type);

		$result = $this->db->get('student');
		return $result->result();
	}

	public function doSignIn($nrp, $password) {
		$newNrp = substr($nrp, 1);
		$res = $this->db->get_where('student', array('nrp' => $newNrp));

//		echo $newNrp.' '.$password;

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

	public function addStudent($nrp, $student_name) {
		$q = $this->db->get_where('student', array('nrp' => $nrp));

		if($q->num_rows() == 0) {
			$data = array('nrp' => $nrp, 'full_name' => $student_name);
			$this->db->insert('student', $data);
			return 'success';
		} else {
			return 'nrp exists';
		}
	}


	public function editStudent($nrp,$student_name) {
		$data = array('full_name' => $student_name);
		$this->db->where('nrp', $nrp);
		$this->db->update('student', $data);
	}

	public function delStudent($nrp) {
		$this->db->where('nrp', $nrp);
		$this->db->update('student', array('is_deleted' => 1));
	}

}
?>
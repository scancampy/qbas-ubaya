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

}
?>
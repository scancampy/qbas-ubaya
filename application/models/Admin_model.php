<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function doSignIn($username, $password) {
		$res = $this->db->get_where('admin', array('username' => $username));

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
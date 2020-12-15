<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data = array();

		if($this->session->flashdata('notif')) {
			if($this->session->flashdata('notif') == 'login_false') {
			$data['alert'] = "
			    const Toast = Swal.mixin({
			      toast: true,
			      position: 'top-end',
			      showConfirmButton: false,
			      timer: 3000
			    });

			      Toast.fire({
			        icon: 'error',
			        title: 'Nrp atau PIN salah'
			      });
			   ";	
			}
		}
		if($this->input->post('btnsignin')) {
			$cek =  $this->student_model->doSignIn($this->input->post('snrp'), $this->input->post('password'));

			if($cek == false) {
				$this->session->set_flashdata('notif', 'login_false');
				redirect('');
			} else {
				$this->session->set_userdata('user', $cek);
				redirect('dashboard');
			}
		}
		$this->load->view('v_login', $data);
	}
}
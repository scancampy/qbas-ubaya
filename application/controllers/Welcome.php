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
				// if login failed, try login as lecturer
				$ceklecturer = $this->lecturer_model->doSignIn($this->input->post('snrp'), $this->input->post('password'));

				if($ceklecturer == false) {
					// if login failed, try login as admin
					$cekadmin = $this->admin_model->doSignIn($this->input->post('snrp'), $this->input->post('password'));

					if($cekadmin == true) {
						$this->session->set_userdata('user', $cekadmin);
					    $this->session->set_userdata('menu_type', 'admin');
						redirect('admin');
					} else {
						$this->session->set_flashdata('notif', 'login_false');
						redirect('');
					}
					
				} else {
					$this->session->set_userdata('user', $ceklecturer);
					$this->session->set_userdata('menu_type', 'lecturer');
					redirect('Lecturer');
				}
			} else {
				$this->session->set_userdata('user', $cek);
				$this->session->set_userdata('menu_type', 'student');
				redirect('dashboard');
			}
		}
		$this->load->view('v_login', $data);
	}
}

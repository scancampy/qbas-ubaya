<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set("Asia/Bangkok");

class Admin extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Your own constructor code

        if(!$this->session->userdata('user')) {
        	redirect('');
        }
    }

    // SEMESTER
    public function jsongetsemester() {
    	if($this->input->post('sentid')) {
    		$result = $this->semester_model->getSemester($this->input->post('sentid'));
    		echo json_encode(array('result' => 'success', 'data' => $result));
    	} else {
    		echo json_encode(array('result' => 'failed'));
    	}
    }

    public function semester() {
    	$data = array();
		$data['js'] ='
		$("#btnaddsemester").on("click", function() {
			$("#hiddenid").val("");
			$("#semester_name").val("");	
			$("#inactive_semester").prop("checked", true);
			$("#active_semester").prop("checked", false);
		});

		$("body").on("click",".semesteredit", function() {
			var id = $(this).attr("semesterid");
		    $.post("'.base_url('admin/jsongetsemester').'", { sentid: id}, function(data){ 
				var obj = JSON.parse(data);
				var sn = obj.data[0].semester_name;
				var id = obj.data[0].id;
				var ia = obj.data[0].is_active;
				$("#hiddenid").val(id);
				$("#semester_name").val(sn);

				if(obj.data[0].is_active == 1) {
					$("#active_semester").prop( "checked", true );
				} else {
					$("#inactive_semester").prop( "checked", true );
				}

				$("#modalAddSemester").modal();
			})
		});';

// handle data table
		$data['js'] .= ' $("#tablearticle").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';
		if($this->input->post('btnSubmit')) {
			if($this->input->post('hiddenid')) {
				$this->semester_model->editSemester($this->input->post('hiddenid'), $this->input->post('semester_name'), $this->input->post('is_active'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Semester have been updated'));
			} else {
				$this->semester_model->addSemester($this->input->post('semester_name'), $this->input->post('is_active'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'New semester have been added'));
			}
			
			redirect('admin/semester');
		}

		$data['user'] = $this->session->userdata('user');
		$data['menu_type'] = $this->session->userdata('menu_type');	

		// notif
		if($this->session->flashdata('notif')) {
			$notif = $this->session->flashdata('notif');
			if($notif['type'] == 'success') {
				$data['js'] .= '
				const Toast = Swal.mixin({
				      toast: true,
				      position: "top-end",
				      showConfirmButton: false,
				      timer: 3000
				    });
				    Toast.fire({
				        icon: "success",
				        title: "'.$notif['msg'].'"
				      });';
			}
		}

		$data['name'] = $this->session->userdata('user')->full_name;
		$data['title'] = "Master Semester";
		$data['semester'] = $this->semester_model->getSemester(null, array('is_deleted' => 0));

		$this->load->view('v_header', $data);
		$this->load->view('v_master_semester', $data);
		$this->load->view('v_footer', $data);

    }
	/// END OF SEMESTER

	// COURSE
    public function jsongetcourse() {
    	if($this->input->post('sentid')) {
    		$result = $this->semester_model->getSemester($this->input->post('sentid'));
    		echo json_encode(array('result' => 'success', 'data' => $result));
    	} else {
    		echo json_encode(array('result' => 'failed'));
    	}
    }

    public function course() {
    	$data = array();
		$data['js'] ='
		$("#btnaddsemester").on("click", function() {
			$("#hiddenid").val("");
			$("#semester_name").val("");	
			$("#inactive_semester").prop("checked", true);
			$("#active_semester").prop("checked", false);
		});

		$("body").on("click",".semesteredit", function() {
			var id = $(this).attr("semesterid");
		    $.post("'.base_url('admin/jsongetsemester').'", { sentid: id}, function(data){ 
				var obj = JSON.parse(data);
				var sn = obj.data[0].semester_name;
				var id = obj.data[0].id;
				var ia = obj.data[0].is_active;
				$("#hiddenid").val(id);
				$("#semester_name").val(sn);

				if(obj.data[0].is_active == 1) {
					$("#active_semester").prop( "checked", true );
				} else {
					$("#inactive_semester").prop( "checked", true );
				}

				$("#modalAddSemester").modal();
			})
		});';

		// handle data table
		$data['js'] .= ' $("#tablearticle").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';

		if($this->input->post('btnSubmit')) {
			if($this->input->post('hiddenid')) {
				$this->semester_model->editSemester($this->input->post('hiddenid'), $this->input->post('semester_name'), $this->input->post('is_active'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Semester have been updated'));
			} else {
				$this->semester_model->addSemester($this->input->post('semester_name'), $this->input->post('is_active'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'New semester have been added'));
			}
			
			redirect('admin/semester');
		}

		$data['user'] = $this->session->userdata('user');
		$data['menu_type'] = $this->session->userdata('menu_type');	

		// notif
		if($this->session->flashdata('notif')) {
			$notif = $this->session->flashdata('notif');
			if($notif['type'] == 'success') {
				$data['js'] .= '
				const Toast = Swal.mixin({
				      toast: true,
				      position: "top-end",
				      showConfirmButton: false,
				      timer: 3000
				    });
				    Toast.fire({
				        icon: "success",
				        title: "'.$notif['msg'].'"
				      });';
			}
		}

		$data['name'] = $this->session->userdata('user')->full_name;
		$data['title'] = "Master Course";
		$data['course'] = $this->course_model->getCourse(null, array('is_deleted' => 0));

		$this->load->view('v_header', $data);
		$this->load->view('v_master_course', $data);
		$this->load->view('v_footer', $data);

    }
	/// END OF COURSE

   
	public function index() { 
		$data = array();
		$data['user'] = $this->session->userdata('user');
		$data['menu_type'] = $this->session->userdata('menu_type');

		if($this->session->flashdata('notif') == 'success') {
			$data['alert'] = "
			    const Toast = Swal.mixin({
			      toast: true,
			      position: 'top-end',
			      showConfirmButton: false,
			      timer: 3000
			    });

			      Toast.fire({
			        icon: 'success',
			        title: 'Your attendances have been recorded successfully'
			      });
			   ";	
		} else if($this->session->flashdata('notif') == 'failed') {
			$data['alert'] = "
			    const Toast = Swal.mixin({
			      toast: true,
			      position: 'top-end',
			      showConfirmButton: false,
			      timer: 3000
			    });

			      Toast.fire({
			        icon: 'error',
			        title: 'Invalid class codes. Unable to record attendances'
			      });
			   ";	
		}

		if($this->input->post('btnSubmit')) {
			//echo $this->input->post('classcode');
			if($this->attendances_model->checkAuthenticator($data['user']->nrp,  $this->input->post('classcode'))) {
				$this->session->set_flashdata('notif', 'success');
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('notif', 'failed');
				redirect('dashboard');
			}
		}
		
		$data['js'] = 'var serverTime = '.time().'; 
var localTime = parseInt(+Date.now()/1000);
var timeDiff = serverTime - localTime;

console.log("server" + serverTime);
console.log("local" + localTime);

setInterval(function () {
    //console.log();
    var date = new Date((+Date.now() + timeDiff) );
	// Hours part from the timestamp
	var hours = date.getHours();
	// Minutes part from the timestamp
	var minutes = "0" + date.getMinutes();
	// Seconds part from the timestamp
	var seconds = "0" + date.getSeconds();

	// Will display time in 10:30:23 format
	var formattedTime = hours + ":" + minutes.substr(-2) + ":" + seconds.substr(-2);
	$("#clock").html(formattedTime);
}, 1000);';
		
		
		$this->load->view('v_header', $data);
		$this->load->view('v_admin', $data);
		$this->load->view('v_footer', $data);
	}

	public function delsemester($id) {
		$this->semester_model->delSemester($id);
		redirect('admin/semester');
	}

	public function signout() {
		$this->session->sess_destroy();
		redirect('');
	}

}

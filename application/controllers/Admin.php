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

    public function delsemester($id) {
		$this->semester_model->delSemester($id);
		$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Semester have been deleted'));
		redirect('admin/semester');
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
    		$result = $this->course_model->getCourse($this->input->post('sentid'));
    		echo json_encode(array('result' => 'success', 'data' => $result));
    	} else {
    		echo json_encode(array('result' => 'failed'));
    	}
    }

    public function delcourse($id) {
		$this->course_model->delCourse($id);
		$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Course have been deleted'));
		redirect('admin/course');
	}

    public function course() {
    	$data = array();
		$data['js'] ='
		$("#btnaddcourse").on("click", function() {
			$("#hiddenid").val("");
			$("#course_name").val("");
			$("#course_id").val("");
			$("#course_short_name").val("");
			$("#course_id").prop("disabled", false);
		});

		$("body").on("click",".courseedit", function() {
			var id = $(this).attr("courseid");
		    $.post("'.base_url('admin/jsongetcourse').'", { sentid: id}, function(data){ 
		    	
				var obj = JSON.parse(data);
				var cn = obj.data[0].course_name;
				var id = obj.data[0].course_id;
				var sn = obj.data[0].course_short_name;

				$("#hiddenid").val(id);
				$("#course_name").val(cn);
				$("#course_id").val(id);
				$("#course_short_name").val(sn);
				$("#course_id").prop("disabled", true);
				
				$("#modalAddCourse").modal();
			})
		});';

		// handle data table
		$data['js'] .= ' $("#tablearticle").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';

		if($this->input->post('btnSubmit')) {
			if($this->input->post('hiddenid')) {
				$this->course_model->editCourse($this->input->post('hiddenid'), $this->input->post('course_name'), $this->input->post('course_short_name'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Course have been updated'));
			} else {
				$result = $this->course_model->addCourse($this->input->post('course_id'), $this->input->post('course_name'), $this->input->post('course_short_name'));

				if($result =='success') {
					$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'New course have been added'));
				} else if($result =='course_id exists') {
					$this->session->set_flashdata('notif', array('type' => 'failed', 'msg' => 'Course ID already exist. Please check again'));
				}
			}
			
			redirect('admin/course');
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
			} else if($notif['type'] == 'failed') {
				$data['js'] .= '
				const Toast = Swal.mixin({
				      toast: true,
				      position: "top-end",
				      showConfirmButton: false,
				      timer: 3000
				    });
				    Toast.fire({
				        icon: "warning",
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

	// STUDENT
    public function jsongetstudent() {
    	if($this->input->post('sentid')) {
    		$result = $this->student_model->getStudents($this->input->post('sentid'));
    		echo json_encode(array('result' => 'success', 'data' => $result));
    	} else {
    		echo json_encode(array('result' => 'failed'));
    	}
    }

    public function delstudent($nrp) {
		$this->student_model->delStudent($nrp);
		$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Student have been deleted'));
		redirect('admin/student');
	}

    public function student() {
    	$data = array();
		$data['js'] ='
		$("#btnaddstudent").on("click", function() {
			$("#hiddenid").val("");
			$("#student_name").val("");
			$("#nrp").val("");
			$("#nrp").prop("disabled", false);
		});

		$("body").on("click",".studentedit", function() {
			var id = $(this).attr("studentid");
		    $.post("'.base_url('admin/jsongetstudent').'", { sentid: id}, function(data){ 
		    	
				var obj = JSON.parse(data);
				var fn = obj.data[0].full_name;
				var id = obj.data[0].nrp;

				$("#hiddenid").val(id);
				$("#student_name").val(fn);
				$("#nrp").val(id);
				$("#nrp").prop("disabled", true);
				
				$("#modalAddStudent").modal();
			})
		});';

		// handle data table
		$data['js'] .= ' $("#tablearticle").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';

		if($this->input->post('btnSubmit')) {
			if($this->input->post('hiddenid')) {
				$this->student_model->editStudent($this->input->post('hiddenid'), $this->input->post('student_name'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Student have been updated'));
			} else {
				$result = $this->student_model->addStudent($this->input->post('nrp'), $this->input->post('student_name'));

				if($result =='success') {
					$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'New student have been added'));
				} else if($result =='course_id exists') {
					$this->session->set_flashdata('notif', array('type' => 'failed', 'msg' => 'NRP already exist. Please check again'));
				}
			}
			
			redirect('admin/student');
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
			} else if($notif['type'] == 'failed') {
				$data['js'] .= '
				const Toast = Swal.mixin({
				      toast: true,
				      position: "top-end",
				      showConfirmButton: false,
				      timer: 3000
				    });
				    Toast.fire({
				        icon: "warning",
				        title: "'.$notif['msg'].'"
				      });';
			}
		}

		$data['name'] = $this->session->userdata('user')->full_name;
		$data['title'] = "Master Student";
		$data['student'] = $this->student_model->getStudents(null, array('is_deleted' => 0));

		$this->load->view('v_header', $data);
		$this->load->view('v_master_student', $data);
		$this->load->view('v_footer', $data);

    }
	/// END OF STUDENT

	// LECTURER
    public function jsongetlecturer() {
    	if($this->input->post('sentid')) {
    		$result = $this->lecturer_model->getLecturer($this->input->post('sentid'));
    		echo json_encode(array('result' => 'success', 'data' => $result));
    	} else {
    		echo json_encode(array('result' => 'failed'));
    	}
    }

    public function dellecturer($npk) {
		$this->lecturer_model->delLecturer($npk);
		$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Lecturer have been deleted'));
		redirect('admin/lecturer');
	}

    public function lecturer() {
    	$data = array();
		$data['js'] ='
		$("#btnaddstudent").on("click", function() {
			$("#hiddenid").val("");
			$("#student_name").val("");
			$("#nrp").val("");
			$("#nrp").prop("disabled", false);
		});

		$("body").on("click",".studentedit", function() {
			var id = $(this).attr("studentid");
		    $.post("'.base_url('admin/jsongetstudent').'", { sentid: id}, function(data){ 
		    	
				var obj = JSON.parse(data);
				var fn = obj.data[0].full_name;
				var id = obj.data[0].nrp;

				$("#hiddenid").val(id);
				$("#student_name").val(fn);
				$("#nrp").val(id);
				$("#nrp").prop("disabled", true);
				
				$("#modalAddStudent").modal();
			});
		});';

		// handle data table
		$data['js'] .= ' $("#tablearticle").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';

		if($this->input->post('btnSubmit')) {
			if($this->input->post('hiddenid')) {
				$this->lecturer_model->editLecturer($this->input->post('hiddenid'), $this->input->post('full_name'));
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Lecturer have been updated'));
			} else {
				$result = $this->lecturer_model->addLecturer($this->input->post('npk'), $this->input->post('full_name'));

				if($result =='success') {
					$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'New lecturer have been added'));
				} else if($result =='npk exists') {
					$this->session->set_flashdata('notif', array('type' => 'failed', 'msg' => 'NPK already exist. Please check again'));
				}
			}
			
			redirect('admin/lecturer');
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
			} else if($notif['type'] == 'failed') {
				$data['js'] .= '
				const Toast = Swal.mixin({
				      toast: true,
				      position: "top-end",
				      showConfirmButton: false,
				      timer: 3000
				    });
				    Toast.fire({
				        icon: "warning",
				        title: "'.$notif['msg'].'"
				      });';
			}
		}

		$data['name'] = $this->session->userdata('user')->full_name;
		$data['title'] = "Master Lecturer";
		$data['lecturer'] = $this->lecturer_model->getLecturer(null, array('is_deleted' => 0));

		$this->load->view('v_header', $data);
		$this->load->view('v_master_lecturer', $data);
		$this->load->view('v_footer', $data);

    }
	/// END OF LECTURER

    // START OF MANAGE CLASS
    public function delcourseopen($sem, $id) {
    	$this->course_model->delCourseOpen($sem, $id);
    	$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Class have been deleted'));
    	redirect('admin/manageclass?sem='.$sem);
    }

    public function jsongetcourseopen() {
    	if($this->input->post('sentid')) {
    		$result = $this->course_model->getCourseOpen(null, $this->input->post('sentid'));
    		$lecturer = $this->course_model->getLecturerList(null,  $this->input->post('sentid'));
    		

    		echo json_encode(array('result' => 'success', 'data' => $result, 'lecturer' => $lecturer));
    	} else {
    		echo json_encode(array('result' => 'failed'));
    	}
    }

    public function manageclass() {
    	$data = array();
		$data['user'] = $this->session->userdata('user');
		$data['menu_type'] = $this->session->userdata('menu_type');
		$data['js'] = '
		$("#selectsemester").on("change", function() {
			$("#formsemester").submit();
		});

		$("body").on("click", ".dellecturer", function() {
			$(this).parent().parent().remove();
		});

		var numlecturer =0;

		$("body").on("click", ".lectureredit", function() {
			var id = $(this).attr("courseopenid");

			$("#course_open_hidden_id").val(id);
		    $.post("'.base_url('admin/jsongetcourseopen').'", { sentid: id}, function(data){ 
		    	
				var obj = JSON.parse(data);
				if(obj.lecturer.length > 0) {
					$("#containerlecturer").html("");
					numlecturer = 0;

					for(var i =0; i < obj.lecturer.length; i++) {
						var tr = "<tr>" +
                        		  "<td>" + (i+1) + "</td>" +
                        		  "<td>" + obj.lecturer[i].lecturer_npk + "</td>" + 
                        		  "<td>" + obj.lecturer[i].full_name + "</td>" + 
                        		  "<td><input type=\"hidden\" name=\"lecturer[]\" value=\"" + obj.lecturer[i].lecturer_npk + "\" /><button type=\"button\" class=\"btn btn-danger dellecturer\"><i class=\"fas fa-trash\"></i></button></td>" + 
                        		  "</tr>";
                       numlecturer++;
                       $("#containerlecturer").append(tr);
					}		
				} else {
					numlecturer =0;
					var tr = "<tr>" + 
                        "<td colspan=\"4\">No data</td>" + 
                      "</tr>";

                     $("#containerlecturer").html(tr);
				}
				$("#course_id_info").val(obj.data[0].course_id);
				$("#course_name_info").val(obj.data[0].course_name);
				$("#kp_info").val(obj.data[0].KP);
				$("#modalAddStudent").modal();
			});
				
			$("#modalAddLecturer").modal();
		});
		';

		$data['js'] .= '$("#btnaddlecturer").on("click",function() {
			var npk = $("#chooselecturer").val();
			var name = $("#chooselecturer option:selected").html();

			if(numlecturer == 0) { $("#containerlecturer").html(""); }

           numlecturer++;
			var tr = "<tr>" +
            		  "<td>" + numlecturer + "</td>" +
            		  "<td>" + npk + "</td>" + 
            		  "<td>" + name + "</td>" + 
            		  "<td><input type=\"hidden\" name=\"lecturer[]\" value=\"" + npk + "\" /><button type=\"button\" class=\"btn btn-danger dellecturer\"><i class=\"fas fa-trash\"></i></button></td>" + 
            		  "</tr>";
           $("#containerlecturer").append(tr);
			
		});';

		$data['js'] .= '$("#btnSubmitLecturer").on("click",function(event) {
			// cek
			var hid = $( "#containerlecturer" ).find( "input[type=hidden]" );
			var oldvalue = [];
			var errorinput = false;
			var x = 0;
			for(var i = 0; i < hid.length; i++ ) {
				for(var j = 0; j < oldvalue.length; j++) {
					if(oldvalue[j] == hid[i].value) {
						errorinput = true;
						break;
					}
				}

				oldvalue[x] = hid[i].value;
				x++;
			}

			if(errorinput == true) {
				event.preventDefault();
				alert("Unable to save. Duplicate lecturer found. Please check again.");
			}
		});';

		// handle data table
		$data['js'] .= ' $("#tablearticle").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';

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
			} else if($notif['type'] == 'failed') {
				$data['js'] .= '
				const Toast = Swal.mixin({
				      toast: true,
				      position: "top-end",
				      showConfirmButton: false,
				      timer: 3000
				    });
				    Toast.fire({
				        icon: "warning",
				        title: "'.$notif['msg'].'"
				      });';
			}
		}

		if($this->input->post('btnSubmitLecturer')) {
			$lecturer = $this->input->post('lecturer');

			for($i = 0; $i < count($lecturer); $i++) {
				$res = $this->course_model->findLecturer($this->input->post('course_open_hidden_id'), $lecturer[$i]);

				if(count($res) == 0) {
					$this->course_model->addLecturer($this->input->post('course_open_hidden_id'), $lecturer[$i]);	
				}
			}

			$res = $this->course_model->getLecturerList(null, $this->input->post('course_open_hidden_id'));
			$currentlecturer = array();
			foreach ($res as $key => $value) {
				$currentlecturer[] = $value->lecturer_npk;
			}

			$array3 = array_diff($currentlecturer, $lecturer);
			foreach ($array3 as $key => $value) {
				$this->course_model->removeLecturer($this->input->post('course_open_hidden_id'), $value);
			}

			$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'Lecturer  have been added to the course'));

			redirect('admin/manageclass?sem='.$this->input->get('sem'));
		}

		if($this->input->post('btnSubmitClass')) {
			if($this->course_model->addCourseOpen($this->input->get('sem'), $this->input->post('course_id'), $this->input->post('KP'))) {
				$this->session->set_flashdata('notif', array('type' => 'success', 'msg' => 'New class have been added'));
			} else {
				$this->session->set_flashdata('notif', array('type' => 'failed', 'msg' => 'Class already exist. Please check again'));
			}

			redirect('admin/manageclass?sem='.$this->input->get('sem'));
		}

		$data['name'] = $this->session->userdata('user')->full_name;
		$data['title'] = "Manage Class";
		$data['semester'] = $this->semester_model->getSemester(null, array('is_deleted' => 0));
		$data['course'] = $this->course_model->getCourse(null, array('is_deleted'=>0));
		$data['lecturer'] = $this->lecturer_model->getLecturer(null, array('is_deleted' => 0));

		if($this->input->get('sem')) {
			$data['course_open'] = $this->course_model->getCourseOpen($this->input->get('sem'));
			$data['current_semester'] = $this->semester_model->getSemester($this->input->get('sem'));
		}

		$this->load->view('v_header', $data);
		$this->load->view('v_manage_class', $data);
		$this->load->view('v_footer', $data);
    }
    // END OF MANAGE CLASS

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

	

	public function signout() {
		$this->session->sess_destroy();
		redirect('');
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set("Asia/Bangkok");

class Report extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Your own constructor code

        if(!$this->session->userdata('user')) {
        	redirect('');
        }
    }

    public function attendances($course_open_id, $schedule_id) {
    	$data = array();

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

    	if($this->input->post('btnoverride')) {
    		//print_r($_POST);
    		$nrphid = $this->input->post('nrphid');
    		foreach ($nrphid as $key => $value) {
    			if($this->input->post('checkboxatt_'.$key)) {
    				$this->attendances_model->overrideAttendaces($value, $course_open_id, $schedule_id);
    			}	
    		}
    		$this->session->set_flashdata('notif', 'success');
    		redirect('report/attendances/'.$course_open_id.'/'.$schedule_id);
    	}

    	$data['user'] = $this->session->userdata('user');
    	$data['menu_type'] = $this->session->userdata('menu_type');	

		$data['current'] = $this->lecturer_model->getLecturerClass($data['user']->npk);
		foreach ($data['current'] as $key => $value) {
			if($value->course_open_id == $course_open_id) {
				$data['class'] = $value;
			}
		}

		$data['skedul'] = $this->schedule_model->getSchedule($schedule_id);
		$data['course_open_id']= $course_open_id;
		$data['schedule_id'] = $schedule_id;

		$data['title'] = 'Attendances Report';
		$data['att'] = $this->attendances_model->getAttendances($course_open_id, $schedule_id);

		$data['js'] = '
		$("[data-toggle=\"switch\"]").bootstrapSwitch({ onText: "ATTEND",
    offText: "NOT ATTEND", });
    ';
		
		$this->load->view('v_header', $data);
		$this->load->view('v_report_attendances', $data);
		$this->load->view('v_footer', $data);
    }

	public function index() { 
		$data = array();
		$data['user'] = $this->session->userdata('user');
		$data['menu_type'] = $this->session->userdata('menu_type');	
		$data['current'] = $this->lecturer_model->getLecturerClass($data['user']->npk);
		

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

		if($this->input->get('selectcourse')) {
			$data['skedul'] = $this->schedule_model->getSchedule(null, $this->input->get('selectcourse'));
			foreach ($data['current'] as $key => $value) {
				if($value->course_open_id == $this->input->get('selectcourse')) {
					$data['class'] = $value;
				}
			}
		}
		

		
		$data['js'] = '
		
		$("#myModal").on("hide.bs.modal", function(){
		  clearInterval();
		});

		$(".btnqr").on("click", function() {
			var id = $(this).attr("attid");

			setInterval(function(){ 
				$.post("'.base_url('lecturer/generateqr').'", {nid:id}, function(data) {
					//alert(data);
					var obj = JSON.parse(data);
					if(obj.result == true) {
						var qr = obj.qr;
						$("#qrimage").attr("src", "'.base_url('assets/images/').'" + qr);
					}
					
				});
			 }, 3000);

			 $.post("'.base_url('lecturer/generateqr').'", {nid:id}, function(data) {
					//alert(data);
					var obj = JSON.parse(data);
					if(obj.result == true) {
						var qr = obj.qr;
						$("#qrimage").attr("src", "'.base_url('assets/images/').'" + qr);
					}
					
				});
		
			
		});

		var serverTime = '.time().'; 
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

		$data['js'] .= '
			$("#selectcourse").on("change", function() {
				$("#formreport").submit();
			});
		';

		//$this->attendances_model->checkAttendances("s");
		$data['title'] = 'Report';
		$data['upcoming'] = $this->lecturer_model->upcomingClass($data['user']->npk);


		
		$this->load->view('v_header', $data);
		$this->load->view('v_report', $data);
		$this->load->view('v_footer', $data);
	}

	public function student() {
		$data = array();
		$data['user'] = $this->session->userdata('user');
		$data['menu_type'] = $this->session->userdata('menu_type');	
		$data['semester'] = $this->semester_model->getSemester(null, array('is_active' => 1));


		$data['title'] = 'Attendances Report';
		$data['mycourse'] = $this->course_model->getStudentCourseOpen($data['semester'][0]->id , $data['user']->nrp);
		$data['myatt'] = $this->attendances_model->getStudentAbsence($data['user']->nrp);

		$data['js'] = ' $("#tablearticle").DataTable({
   	      "responsive": true	});';

		$this->load->view('v_header', $data);
		$this->load->view('v_report_student_attendances', $data);
		$this->load->view('v_footer', $data);

	}

	

}

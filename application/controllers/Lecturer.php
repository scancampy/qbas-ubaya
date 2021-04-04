<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set("Asia/Bangkok");

class Lecturer extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Your own constructor code

        if(!$this->session->userdata('user')) {
        	redirect('');
        }
    }

    public function generateqr() {
    	if($this->input->post('nid')) {
    	//	$nrp = $this->input->post('nnrp');
    		$schedule_id = $this->input->post('nid');
    	//	$course_open_id = $this->input->post('ncourse_open_id');
    		$hash = $this->lecturer_model->requestQR($schedule_id);

    		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
	        $config['cacheable']    = true; //boolean, the default is true
	        $config['cachedir']     = './assets/'; //string, the default is application/cache/
	        $config['errorlog']     = './assets/'; //string, the default is application/logs/
	        $config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
	        $config['quality']      = true; //boolean, the default is true
	        $config['size']         = '1024'; //interger, the default is 1024
	        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
	        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
	        $this->ciqrcode->initialize($config);
	 
	        $image_name=strtotime('now').$schedule_id.'.png'; //buat name dari qr code sesuai dengan nim
	 
	        $params['data'] = $hash; //data yang akan di jadikan QR CODE
	        $params['level'] = 'H'; //H=High
	        $params['size'] = 10;
	        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
	        $this->ciqrcode->generate($params); 
    		echo json_encode(array('result' => true,'qr' => $image_name, 'hash' => $hash));
    	} else {
    		echo json_encode(array('result' => false));
    	}

    	// fungsi untuk generate QR CODE*/
        //echo json_encode(array($_POST));
    }

	public function index() { 
		$data = array();
		$data['user'] = $this->session->userdata('user');

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
		//$this->attendances_model->checkAttendances("s");
		$data['upcoming'] = $this->lecturer_model->upcomingClass($data['user']->npk);
		$data['current'] = $this->lecturer_model->getCurrentClass($data['user']->npk);

		foreach ($data['current'] as $key => $value) {
			$data['absence'] = $this->attendances_model->getAttendances($value['course_open_id'], $value['id']);
			$data['studentlist'] = $this->course_model->getStudentList($value['course_open_id']);
			break;
		}
		
		$this->load->view('v_header', $data);
		$this->load->view('v_lecturer', $data);
		$this->load->view('v_footer', $data);
	}

	public function signout() {
		$this->session->sess_destroy();
		redirect('');
	}

}

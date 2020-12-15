<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set("Asia/Bangkok");

class Dashboard extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Your own constructor code

        if(!$this->session->userdata('user')) {
        	redirect('');
        }
    }

    public function generateqr() {
    	if($this->input->post('nnrp') == $this->session->userdata('user')->nrp) {
    		$nrp = $this->input->post('nnrp');
    		$schedule_id = $this->input->post('nid');
    		$course_open_id = $this->input->post('ncourse_open_id');
    		$hash = $this->attendances_model->requestQR($nrp, $course_open_id, $schedule_id);

    	
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
	 
	        $image_name=strtotime('now').$nrp.'.png'; //buat name dari qr code sesuai dengan nim
	 
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
		$data['js'] = '
		$(".btnqr").on("click", function() {
			//alert("Tes");
			var id = $(this).attr("attid");
			var nrp = $(this).attr("attnrp");
			var course_open_id = $(this).attr("attopenid");

			$.post("'.base_url('dashboard/generateqr').'", {nid:id, nnrp:nrp, ncourse_open_id:course_open_id}, function(data) {
				
				var obj = JSON.parse(data);
				if(obj.result == true) {
					var qr = obj.qr;
					$("#qrimage").attr("src", "'.base_url('assets/images/').'" + qr);
				}
				//alert(data);
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
		$data['upcoming'] = $this->attendances_model->checkAttendances($data['user']->nrp);
		$data['current'] = $this->attendances_model->getCurrentClass($data['user']->nrp);

		$this->load->view('v_header', $data);
		$this->load->view('v_attendances', $data);
		$this->load->view('v_footer', $data);
	}

	public function signout() {
		$this->session->sess_destroy();
		redirect('');
	}

	public function manage() {
		$data =array();
		$data['herbal'] = $this->herbal_model->getherbalall();
		$data['js'] = '
				$("#example1").DataTable({
		      "responsive": true,
		      "autoWidth": false,
		    });';

		if($this->session->flashdata('notif')) {
			$data['alert'] = "
			    const Toast = Swal.mixin({
			      toast: true,
			      position: 'top-end',
			      showConfirmButton: false,
			      timer: 3000
			    });

			      Toast.fire({
			        icon: 'success',
			        title: 'Data herbal terhapus.'
			      });
			   ";	
		}

		$this->load->view('v_header', $data);
		$this->load->view('v_manage_herbal', $data);
		$this->load->view('v_footer', $data);
	}

	public function runtrans() {
		$this->herbal_model->runtrans();
	}

	public function delete($id) {
		$this->herbal_model->delHerbal($id);
		$this->session->set_flashdata('notif', 'del_success');
		redirect('herbal/manage');
	}

	public function edit($id) {
		if($this->input->post('btnsubmit')) {
			$update = array('latin' => $this->input->post('namalatin'),
							'simplisia' => $this->input->post('namasimplisia'),
							'suku' => $this->input->post('suku'),
							'mikroskopis' => $this->input->post('mikroskoppis'),
							'senyawa' => $this->input->post('senyawa'),
							'susut_pengeringan' => $this->input->post('susut_pengeringan'),
							'abu_total' => $this->input->post('abu_total'),
							'abu_tidak_larut' => $this->input->post('abu_tidak_larut'),
							'sari_larut_air' => $this->input->post('sari_larut_air'),
							'sari_laut_etanol' => $this->input->post('sari_laut_etanol'),
							'bentuk' => $this->input->post('bentuk'),
							'nama_ekstrak' => $this->input->post('nama_ekstrak'),
							'rendemen' => $this->input->post('rendemen'),
							'pemerian' => $this->input->post('pemerian'),
							'senyawa_identitas' => $this->input->post('senyawa_identitas'),
							'kadar_air' => $this->input->post('kadar_air'),
							'abu_total_ekstrak' => $this->input->post('abu_total_ekstrak'),
							'abu_tidak_larut_asam' => $this->input->post('abu_tidak_larut_asam')
						   );
			$hiddenkandungan =  $this->input->post('hiddenkandungan');
			$kandungan = $this->input->post('kandungan');

			$hiddenkandungankimia =  $this->input->post('hiddenkandungankimia');
			$kandungankimia = $this->input->post('kandungan_kimia');

			$hiddenkandungankimiaekstrak =  $this->input->post('hiddenkandungankimiaekstrak');
			$kandungankimiaekstrak = $this->input->post('kandungan_kimia_ekstrak');

			$hiddencacahan = $this->input->post('hiddencacahan');
			$cacahan = $this->input->post('cacahan');

			$hiddenkromatografi = $this->input->post('hiddenkromatografi');
			$fasegerak = $this->input->post('fasegerak');
			$fasediam = $this->input->post('fasediam');
			$larutanuji = $this->input->post('larutanuji');
			$larutanpembanding = $this->input->post('larutanpembanding');
			$volumepenotolan = $this->input->post('volumepenotolan');
			$deteksi = $this->input->post('deteksi');
			
			$this->herbal_model->updateHerbal($id, $update, $kandungan, $hiddenkandungan, $kandungankimia, $hiddenkandungankimia, $kandungankimiaekstrak, $hiddenkandungankimiaekstrak, $cacahan, $hiddencacahan, $fasegerak, $fasediam,$larutanuji, $larutanpembanding, $volumepenotolan, $deteksi, $hiddenkromatografi);

			// Count total files
      		$countfiles = count($_FILES['fotosimplisia']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotosimplisia']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotosimplisia']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotosimplisia']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotosimplisia']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotosimplisia']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotosimplisia']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotosimplisia']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesSimplisia($id, $filename);
			           }
      			 }
      		}

      		      					// Count total files
      		$countfiles = count($_FILES['fotomikroskopis']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotomikroskopis']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotomikroskopis']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotomikroskopis']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotomikroskopis']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotomikroskopis']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotomikroskopis']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotomikroskopis']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesMikroskopis($id, $filename);
			           }
      			 }
      		}

      					// Count total files
      		$countfiles = count($_FILES['fotostrukturkimia']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotostrukturkimia']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotostrukturkimia']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotostrukturkimia']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotostrukturkimia']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotostrukturkimia']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotostrukturkimia']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotostrukturkimia']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesStruktur($id, $filename);
			           }
      			 }
      		}

      		$countfiles = count($_FILES['fotostrukturkimiaekstrak']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotostrukturkimiaekstrak']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotostrukturkimiaekstrak']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotostrukturkimiaekstrak']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotostrukturkimiaekstrak']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotostrukturkimiaekstrak']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotostrukturkimiaekstrak']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotostrukturkimiaekstrak']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesStrukturEkstrak($id, $filename);
			           }
      			 }
      		}



			$this->session->set_flashdata('notif', 'add_success');
			redirect('herbal/edit/'.$id);
		}
		$data = array();
		$data['id'] = $id;
		$data['herbal'] = $this->herbal_model->getherbal($id);
		$data['kandungan'] = $this->herbal_model->getKandungan($id);
		$data['kandungankimia'] = $this->herbal_model->getKandunganKimia($id);
		$data['kandungankimiaekstrak'] = $this->herbal_model->getKandunganKimiaEkstrak($id);
		$data['cacahan'] = $this->herbal_model->getCacahan($id);
		$data['imagesimplisia'] = $this->herbal_model->getImageSimplisia($id);
		$data['imagepemerian'] = $this->herbal_model->getImagePemerian($id);
		$data['imagestrukturkimia'] = $this->herbal_model->getImageStrukturKimia($id);
		$data['imagestrukturkimiaekstrak'] = $this->herbal_model->getImageStrukturKimiaEkstrak($id);

		$data['kromatografi'] = $this->herbal_model->getKromatografi($id);

		if($this->session->flashdata('notif')) {
			$data['alert'] = "
			    const Toast = Swal.mixin({
			      toast: true,
			      position: 'top-end',
			      showConfirmButton: false,
			      timer: 3000
			    });

			      Toast.fire({
			        icon: 'success',
			        title: 'Data herbal tersimpan.'
			      });
			   ";	
		}

		$data['js'] = '
			$("#btnfotosimplisia").on("click", function() {
				$("#containerfoto").append("'.$this->_fotosimplisia().'");
				bsCustomFileInput.init();
			});

			$("#btnkandungankimia").on("click", function() {
				$("#containerkandungankimia").append("<input type=\"text\" class=\"form-control\" id=\"kandungan_kimia\" name=\"kandungan_kimia[]\" style=\"margin-top:5px;\" ><input type=\"hidden\"  name=\"hiddenkandungankimia[]\">");
			});

			$("#btnkandungankimiaekstrak").on("click", function() {
				$("#containerkandungankimiaekstrak").append("<input type=\"text\" class=\"form-control\" id=\"kandungan_kimia_ekstrak\" name=\"kandungan_kimia_ekstrak[]\" style=\"margin-top:5px;\" ><input type=\"hidden\"  name=\"hiddenkandungankimiaekstrak[]\">");
			});

			$("#btnkandungan").on("click", function() {
				$("#containerkandungan").append("<input type=\"text\" class=\"form-control\" id=\"kandungan\" name=\"kandungan[]\" style=\"margin-top:5px;\" ><input type=\"hidden\"  name=\"hiddenkandungan[]\">");
			});

			$("#btncacahan").on("click", function() {
				$("#containercacahan").append("<input type=\"text\" class=\"form-control\" id=\"kandungan\" name=\"cacahan[]\" style=\"margin-top:5px;\" ><input type=\"hidden\"  name=\"hiddencacahan[]\">");
			});

			$("#btnaddversion").on("click", function() {
				var x = parseInt($("#jumlahversi").val());
				x += 1;
				$("#jumlahversi").val(x);
				$("#kromatograficontainer").append("<div class=\"card\"><div class=\"card-header\"><h3 class=\"card-title\">Versi " + $("#jumlahversi").val() +"</h3><input type=\"hidden\" name=\"hiddenkromatografi[]\" /></div>'.$this->_kromatografi().'");
				bsCustomFileInput.init();
			});

			$("#btnfotomikroskopis").on("click", function() {
				$("#containerfotomikroskopis").append("'.$this->_fotomikroskopis().'");
				bsCustomFileInput.init();
			});

			$("#btnfotostrukturkimia").on("click", function() {
				$("#containerfotostrukturkimia").append("'.$this->_fotostrukturkimia().'");
				bsCustomFileInput.init();
			});

			$("#btnfotostrukturkimiaekstrak").on("click", function() {
				$("#containerfotostrukturkimiaekstrak").append("'.$this->_fotostrukturkimiaekstrak().'");
				bsCustomFileInput.init();
			});


			$(".btndelimagesimplisia").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var idimagesimplisia = $(this).attr("idimagesimplisia");
					$.post("'.base_url('index.php/herbal/deleteimagesimplisia').'", { id:idimagesimplisia }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).remove();
					});
				}
			});

			$(".btndelimagepemerian").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var idimagepemerian = $(this).attr("idimagepemerian");
					$.post("'.base_url('index.php/herbal/deleteimagepemerian').'", { id:idimagepemerian }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).remove();
					});
				}
			});

			$(".btndelimagestrukturkimia").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var idimagestrukturkimia = $(this).attr("idimagestrukturkimia");
					$.post("'.base_url('index.php/herbal/deleteimagestrukturkimia').'", { id:idimagestrukturkimia }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).remove();
					});
				}
			});

			$(".btndelimagestrukturkimiaekstrak").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var idimagestrukturkimiaekstrak = $(this).attr("idimagestrukturkimiaekstrak");
					$.post("'.base_url('index.php/herbal/deleteimagestrukturkimiaekstrak').'", { id:idimagestrukturkimiaekstrak }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).remove();
					});
				}
			});

			$(".btndelkandungan").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var kandunganid = $(this).attr("kandunganid");
					$.post("'.base_url('index.php/herbal/deletekandungan').'", { id:kandunganid }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).parent().remove();
					});
				}
			});

			$(".btndelkandungankimia").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var kandunganid = $(this).attr("kandunganid");
					$.post("'.base_url('index.php/herbal/deletekandungankimia').'", { id:kandunganid }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).parent().remove();
					});
				}
			});


			$(".btndelkandungankimiaekstrak").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var kandunganid = $(this).attr("kandunganid");
					$.post("'.base_url('index.php/herbal/deletekandungankimiaekstrak').'", { id:kandunganid }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).parent().remove();
					});
				}
			});

			$(".btndelcacahan").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var cacahanid = $(this).attr("cacahanid");
					$.post("'.base_url('index.php/herbal/deletecacahan').'", { id:cacahanid }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).parent().remove();
					});
				}
			});

			$(".btndelkromatografi").on("click", function() {
				if(confirm("Yakin hapus?")) {
					var kromatografiid = $(this).attr("kromatografiid");
					$.post("'.base_url('index.php/herbal/deletekromatografi').'", { id:kromatografiid }, function(data) {
						//alert(data);
					});

					$(this).parent().fadeOut(500, function(){
						$(this).parent().remove();
					});
				}
			});
		';

		$this->load->view('v_header', $data);
		$this->load->view('v_edit_herbal', $data);
		$this->load->view('v_footer', $data);
	}

	public function deletekandungan() {
		$this->herbal_model->delKandungan($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deletekandungankimia() {
		$this->herbal_model->delKandunganKimia($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deletekandungankimiaekstrak() {
		$this->herbal_model->delKandunganKimiaEkstrak($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deleteimagesimplisia() {
		$this->herbal_model->delimagesimplisia($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deleteimagestrukturkimia() {
		$this->herbal_model->delimagestrukturkimia($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deleteimagestrukturkimiaekstrak() {
		$this->herbal_model->delimagestrukturkimiaekstrak($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deleteimagepemerian() {
		$this->herbal_model->delimagepemerian($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deletekromatografi() {
		$this->herbal_model->delKromatografi($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function deletecacahan() {
		$this->herbal_model->delCacahan($this->input->post('id'));
		echo json_encode(array('result' => 'oke '.$this->input->post('id')));
	}

	public function add()
	{
		if($this->input->post('btnsubmit')) {
			$insert = array('latin' => $this->input->post('namalatin'),
							'simplisia' => $this->input->post('namasimplisia'),
							'suku' => $this->input->post('suku'),
							'mikroskopis' => $this->input->post('mikroskoppis'),
							'senyawa' => $this->input->post('senyawa'),
							'susut_pengeringan' => $this->input->post('susut_pengeringan'),
							'abu_total' => $this->input->post('abu_total'),
							'abu_tidak_larut' => $this->input->post('abu_tidak_larut'),
							'sari_larut_air' => $this->input->post('sari_larut_air'),
							'sari_laut_etanol' => $this->input->post('sari_laut_etanol'),
							'bentuk' => $this->input->post('bentuk'),
							'nama_ekstrak' => $this->input->post('nama_ekstrak'),
							'rendemen' => $this->input->post('rendemen'),
							'pemerian' => $this->input->post('pemerian'),
							'senyawa_identitas' => $this->input->post('senyawa_identitas'),
							'kadar_air' => $this->input->post('kadar_air'),
							'abu_total_ekstrak' => $this->input->post('abu_total_ekstrak'),
							'abu_tidak_larut_asam' => $this->input->post('abu_tidak_larut_asam')
						   );
			
			$kandungan = $this->input->post('kandungan');
			$cacahan = $this->input->post('cacahan');
			$fasegerak = $this->input->post('fasegerak');
			$fasediam = $this->input->post('fasediam');
			$larutanuji = $this->input->post('larutanuji');
			$larutanpembanding = $this->input->post('larutanpembanding');
			$volumepenotolan = $this->input->post('volumepenotolan');
			$deteksi = $this->input->post('deteksi');			
			$kandungankimia = $this->input->post('kandungan_kimia');
			$kandungankimiaekstrak = $this->input->post('kandungan_kimia_ekstrak');
			
			
			$lastid = $this->herbal_model->addherbal($insert, $kandungan, $kandungankimia, $kandungankimiaekstrak, $cacahan, $fasegerak, $fasediam,$larutanuji, $larutanpembanding, $volumepenotolan, $deteksi, $_FILES['gambarklt']['name']);
			
			// Count total files
      		$countfiles = count($_FILES['fotosimplisia']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotosimplisia']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotosimplisia']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotosimplisia']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotosimplisia']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotosimplisia']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotosimplisia']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotosimplisia']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesSimplisia($lastid, $filename);
			           }
      			 }
      		}

      					// Count total files
      		$countfiles = count($_FILES['fotomikroskopis']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotomikroskopis']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotomikroskopis']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotomikroskopis']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotomikroskopis']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotomikroskopis']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotomikroskopis']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotomikroskopis']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesMikroskopis($lastid, $filename);
			           }
      			 }
      		}

      					// Count total files
      		$countfiles = count($_FILES['fotostrukturkimia']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotostrukturkimia']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotostrukturkimia']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotostrukturkimia']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotostrukturkimia']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotostrukturkimia']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotostrukturkimia']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotostrukturkimia']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesStruktur($lastid, $filename);
			           }
      			 }
      		}

      		$countfiles = count($_FILES['fotostrukturkimiaekstrak']['name']);
 
      		// Looping all files
      		for($i=0;$i<$countfiles;$i++){
      			 if(!empty($_FILES['fotostrukturkimiaekstrak']['name'][$i])){
			      			 	// Define new $_FILES array - $_FILES['file']
			          $_FILES['file']['name'] = $_FILES['fotostrukturkimiaekstrak']['name'][$i];
			          $_FILES['file']['type'] = $_FILES['fotostrukturkimiaekstrak']['type'][$i];
			          $_FILES['file']['tmp_name'] = $_FILES['fotostrukturkimiaekstrak']['tmp_name'][$i];
			          $_FILES['file']['error'] = $_FILES['fotostrukturkimiaekstrak']['error'][$i];
			          $_FILES['file']['size'] = $_FILES['fotostrukturkimiaekstrak']['size'][$i];


			          // Set preference
			          $config['upload_path'] = './images/'; 
			          $config['allowed_types'] = 'jpg|jpeg|png|gif';
			          $config['max_size'] = '5000'; // max_size in kb
			          $config['encrypt_name'] = true;
			          $config['file_name'] = $_FILES['fotostrukturkimiaekstrak']['name'][$i];
			 
			          //Load upload library
			          $this->load->library('upload',$config); 

			           // File upload
			          if($this->upload->do_upload('file')){
			            // Get data about the file
			            $uploadData = $this->upload->data();
			            $filename = $uploadData['file_name'];
			            $this->herbal_model->addImagesStrukturEkstrak($lastid, $filename);
			           }
      			 }
      		}



			$this->session->set_flashdata('notif', 'add_success');
			redirect('herbal/add');
		}
		
		$data = array();

		if($this->session->flashdata('notif')) {
			$data['alert'] = "
			    const Toast = Swal.mixin({
			      toast: true,
			      position: 'top-end',
			      showConfirmButton: false,
			      timer: 3000
			    });

			      Toast.fire({
			        icon: 'success',
			        title: 'Data herbal tersimpan.'
			      });
			   ";	
		}
		

		$data['js'] = '
			$("#btnkandungankimia").on("click", function() {
				$("#containerkandungankimia").append("<input type=\"text\" class=\"form-control\" id=\"kandungan_kimia\" name=\"kandungan_kimia[]\" style=\"margin-top:5px;\" >");
			});

			$("#btnkandungankimiaekstrak").on("click", function() {
				$("#containerkandungankimiaekstrak").append("<input type=\"text\" class=\"form-control\" id=\"kandungan_kimia_ekstrak\" name=\"kandungan_kimia_ekstrak[]\" style=\"margin-top:5px;\" >");
			});

			$("#btnkandungan").on("click", function() {
				$("#containerkandungan").append("<input type=\"text\" class=\"form-control\" id=\"kandungan\" name=\"kandungan[]\" style=\"margin-top:5px;\" >");
			});

			$("#btncacahan").on("click", function() {
				$("#containercacahan").append("<input type=\"text\" class=\"form-control\" id=\"kandungan\" name=\"cacahan[]\" style=\"margin-top:5px;\" >");
			});

			$("#btnfotosimplisia").on("click", function() {
				$("#containerfoto").append("'.$this->_fotosimplisia().'");
				bsCustomFileInput.init();
			});

			$("#btnfotomikroskopis").on("click", function() {
				$("#containerfotomikroskopis").append("'.$this->_fotomikroskopis().'");
				bsCustomFileInput.init();
			});

			$("#btnfotostrukturkimia").on("click", function() {
				$("#containerfotostrukturkimia").append("'.$this->_fotostrukturkimia().'");
				bsCustomFileInput.init();
			});

			$("#btnfotostrukturkimiaekstrak").on("click", function() {
				$("#containerfotostrukturkimiaekstrak").append("'.$this->_fotostrukturkimiaekstrak().'");
				bsCustomFileInput.init();
			});

			$("#btnaddversion").on("click", function() {
				var x = parseInt($("#jumlahversi").val());
				x += 1;
				$("#jumlahversi").val(x);
				$("#kromatograficontainer").append("<div class=\"card\"><div class=\"card-header\"><h3 class=\"card-title\">Versi " + $("#jumlahversi").val() +"</h3></div>'.$this->_kromatografi().'");
				bsCustomFileInput.init();
			});

		';
		$this->load->view('v_header', $data);
		$this->load->view('v_add_herbal', $data);
		$this->load->view('v_footer', $data);
	}

	function _kromatografi() {
		return addslashes(str_replace(array("\n","\r","\r\n"),'',('<div class="card-body">
                          <div class="form-group">
                            <label for="fasegerak">Fase Gerak</label>
                            <input type="text" class="form-control" name="fasegerak[]" id="fasegerak" >
                          </div>                
                          <div class="form-group">
                            <label for="fasediam">Fase diam</label>
                            <input type="text" class="form-control" name="fasediam[]" id="fasediam" >
                          </div>                
                          <div class="form-group">
                            <label for="larutanuji">Larutan Uji</label>
                            <input type="text" class="form-control" id="larutanuji" name="larutanuji[]" >
                          </div>                
                          <div class="form-group">
                            <label for="larutanpembanding">Larutan Pembanding</label>
                            <input type="text" class="form-control" id="larutanpembanding" name="larutanpembanding[]" >
                          </div>     
                          <div class="form-group">
                            <label for="volumepenotolan">Volume Penotolan</label>
                            <input type="text" class="form-control" id="volumepenotolan" name="volumepenotolan[]" >
                          </div>
                          <div class="form-group">
                            <label for="deteksi">Deteksi</label>
                            <input type="text" class="form-control" id="deteksi" name="deteksi[]" >
                          </div>
                          <div class="form-group">
                            <label for="cacahan">Gambar KLT</label> 
                            <div class="col-md-12">                  
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="gambarklt[]">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                              </div>
                            </div>
                          </div>  
                        </div>
                      </div>')));
	}

	function _fotosimplisia() {
		return addslashes(str_replace(array("\n","\r","\r\n"),'',('<div class="custom-file" style="margin-top:5px;">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="fotosimplisia[]">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>')));
	}

	function _fotomikroskopis() {
		return addslashes(str_replace(array("\n","\r","\r\n"),'',('<div class="custom-file" style="margin-top:5px;">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="fotomikroskopis[]">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>')));
	}

	function _fotostrukturkimia() {
		return addslashes(str_replace(array("\n","\r","\r\n"),'',('<div class="custom-file" style="margin-top:5px;">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="fotostrukturkimia[]">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>')));
	}

	function _fotostrukturkimiaekstrak() {
		return addslashes(str_replace(array("\n","\r","\r\n"),'',('<div class="custom-file" style="margin-top:5px;">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="fotostrukturkimiaekstrak[]">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>')));
	}
}

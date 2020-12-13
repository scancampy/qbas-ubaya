<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

	public function doSignIn($nrp, $password) {
		$newNrp = substr($nrp, 1);
		$res = $this->db->get_where('student', array('nrp' => $newNrp));

		echo $newNrp.' '.$password;

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

	public function runtrans() {
		$data = $this->db->get('herbal');

		$result = $data->result();

		foreach ($result as $key => $value) {
			$datainsert = array('herbal_id' => $value->id, 'kandungan_kimia_simplisia' => $value->kandungan_kimia);
			$this->db->insert('herbal_kimia_simplisia', $datainsert);

			$datainsert = array('herbal_id' => $value->id, 'kandungan_kimia_ekstrak' => $value->kandungan_kimia_ekstrak);
			$this->db->insert('herbal_kimia_ekstrak', $datainsert);
		}
	}

	public function addImagesSimplisia($id, $filename) {
		$data = array('herbal_id' => $id, 'filename' => $filename);
		$this->db->insert('herbal_image_simplisia', $data);
	}

	public function addImagesMikroskopis($id, $filename) {
		$data = array('herbal_id' => $id, 'filename' => $filename);
		$this->db->insert('herbal_image_pemerian', $data);
	}

	public function addImagesStruktur($id, $filename) {
		$data = array('herbal_id' => $id, 'filename' => $filename);
		$this->db->insert('herbal_image_struktur', $data);
	}

	public function addImagesStrukturEkstrak($id, $filename) {
		$data = array('herbal_id' => $id, 'filename' => $filename);
		$this->db->insert('herbal_image_struktur_ekstrak', $data);
	}

	public function getherbal($id) {
		$result =  $this->db->get_where('herbal', array('id' => $id));
		return $result->row();
	}

	public function getherbalall() {
		$this->db->order_by('latin', 'asc');
		$result =  $this->db->get('herbal');
		return $result->result();
	}

	public function getKandungan($id){
		$result =  $this->db->get_where('herbal_kandungan', array('herbal_id' => $id));
		return $result->result();	
	}

	public function getKandunganKimia($id){
		$result =  $this->db->get_where('herbal_kimia_simplisia', array('herbal_id' => $id));
		return $result->result();	
	}

	public function getKandunganKimiaEkstrak($id){
		$result =  $this->db->get_where('herbal_kimia_ekstrak', array('herbal_id' => $id));
		return $result->result();	
	}

	public function getImageSimplisia($id){
		$result =  $this->db->get_where('herbal_image_simplisia', array('herbal_id' => $id));
		return $result->result();	
	}	

	public function getImagePemerian($id){
		$result =  $this->db->get_where('herbal_image_pemerian', array('herbal_id' => $id));
		return $result->result();	
	}

	public function getImageStrukturKimiaEkstrak($id){
		$result =  $this->db->get_where('herbal_image_struktur_ekstrak', array('herbal_id' => $id));
		return $result->result();	
	}	

	public function getImageStrukturKimia($id){
		$result =  $this->db->get_where('herbal_image_struktur', array('herbal_id' => $id));
		return $result->result();	
	}	

	public function delimagesimplisia($id) {
		$result = $this->db->get_where('herbal_image_simplisia', array('id' => $id));
		$row = $result->row();
		if(unlink("./images/".$row->filename)) {
			$this->db->where('id', $id);
			$this->db->delete('herbal_image_simplisia');
		}
	}

	public function delimagepemerian($id) {
		$result = $this->db->get_where('herbal_image_pemerian', array('id' => $id));
		$row = $result->row();
		if(unlink("./images/".$row->filename)) {
			$this->db->where('id', $id);
			$this->db->delete('herbal_image_pemerian');
		}
	}

	public function delimagestrukturkimia($id) {
		$result = $this->db->get_where('herbal_image_struktur', array('id' => $id));
		$row = $result->row();
		if(unlink("./images/".$row->filename)) {
			$this->db->where('id', $id);
			$this->db->delete('herbal_image_struktur');
		}
	}

	public function delimagestrukturkimiaekstrak($id) {
		$result = $this->db->get_where('herbal_image_struktur_ekstrak', array('id' => $id));
		$row = $result->row();
		if(unlink("./images/".$row->filename)) {
			$this->db->where('id', $id);
			$this->db->delete('herbal_image_struktur_ekstrak');
		}
	}

	public function delKandungan($id) {
		$this->db->where('id', $id);
		$this->db->delete('herbal_kandungan');
	}

	public function delKandunganKimia($id) {
		$this->db->where('id', $id);
		$this->db->delete('herbal_kimia_simplisia');
	}

	public function delKandunganKimiaEkstrak($id) {
		$this->db->where('id', $id);
		$this->db->delete('herbal_kimia_ekstrak');
	}

	public function delKromatografi($id) {
		$this->db->where('id', $id);
		$this->db->delete('herbal_kromatografi');
	}

	public function delCacahan($id) {
		$this->db->where('id', $id);
		$this->db->delete('herbal_cacahan');
	}

	public function delHerbal($id) {
		$this->db->where('herbal_id', $id);
		$this->db->delete('herbal_cacahan');

		$this->db->where('herbal_id', $id);
		$this->db->delete('herbal_kandungan');

		$this->db->where('herbal_id', $id);
		$this->db->delete('herbal_kromatografi');

		$q = $this->db->get_where('herbal_image_pemerian', array('herbal_id' => $id));
		if($q->num_rows() > 0) {
			$hq = $q->result();
			foreach ($hq as $key => $value) {
				unlink('./images/'.$value->filename);

				$this->db->where('id', $id);
				$this->db->delete('herbal_image_pemerian');
			}	
		}

		$q = $this->db->get_where('herbal_image_simplisia', array('herbal_id' => $id));
		if($q->num_rows() > 0) {
			$hq = $q->result();
			foreach ($hq as $key => $value) {
				unlink('./images/'.$value->filename);

				$this->db->where('id', $value->id);
				$this->db->delete('herbal_image_simplisia');
			}	
		}


		$q = $this->db->get_where('herbal_image_struktur', array('herbal_id' => $id));
		if($q->num_rows() > 0) {
			$hq = $q->result();
			foreach ($hq as $key => $value) {
				unlink('./images/'.$value->filename);

				$this->db->where('id', $value->id);
				$this->db->delete('herbal_image_struktur');
			}	
		}


		$q = $this->db->get_where('herbal_image_struktur_ekstrak', array('herbal_id' => $id));
		if($q->num_rows() > 0) {
			$hq = $q->result();
			foreach ($hq as $key => $value) {
				unlink('./images/'.$value->filename);

				$this->db->where('id', $value->id);
				$this->db->delete('herbal_image_struktur_ekstrak');
			}	
		}

		$this->db->where('id', $id);
		$this->db->delete('herbal');
	}

	public function getCacahan($id){
		$result =  $this->db->get_where('herbal_cacahan', array('herbal_id' => $id));
		return $result->result();	
	}

	public function getKromatografi($id){
		$result =  $this->db->get_where('herbal_kromatografi', array('herbal_id' => $id));
		return $result->result();	
	}

	public function updateherbal($id, $data, $kandungan, $hiddenkandungan, $kandungankimia, $hiddenkandungankimia, $kandungankimiaekstrak, $hiddenkandungankimiaekstrak, $cacahan, $hiddencacahan, $fasegerak, $fasediam,$larutanuji, $larutanpembanding, $volumepenotolan, $deteksi, $hiddenkromatografi) {
		$this->db->where('id', $id);
		$this->db->update('herbal', $data);

		if(count($hiddenkandungan) >0) {
			foreach ($kandungan as $key => $value) {
				if(trim($value) != '') {
					if($hiddenkandungan[$key] != '') {
						$datakandungan = array( 'kandungan' => $value);
						$this->db->where('id', $hiddenkandungan[$key]);
						$this->db->update('herbal_kandungan', $datakandungan);
					} else {
						$datakandungan = array('herbal_id' => $id, 'kandungan' => $value);
						$this->db->insert('herbal_kandungan', $datakandungan);
					}
				}
			}
		}

		if(count($hiddenkandungankimia) >0) {
			foreach ($kandungankimia as $key => $value) {
				if(trim($value) != '') {
					if($hiddenkandungankimia[$key] != '') {
						$datakandungan = array( 'kandungan_kimia_simplisia' => $value);
						$this->db->where('id', $hiddenkandungankimia[$key]);
						$this->db->update('herbal_kimia_simplisia', $datakandungan);
					} else {
						$datakandungan = array('herbal_id' => $id, 'kandungan_kimia_simplisia' => $value);
						$this->db->insert('herbal_kimia_simplisia', $datakandungan);
					}
				}
			}
		}

		if(count($hiddenkandungankimiaekstrak) >0) {
			foreach ($kandungankimiaekstrak as $key => $value) {
				if(trim($value) != '') {
					if($hiddenkandungankimiaekstrak[$key] != '') {
						$datakandungan = array( 'kandungan_kimia_ekstrak' => $value);
						$this->db->where('id', $hiddenkandungankimiaekstrak[$key]);
						$this->db->update('herbal_kimia_ekstrak', $datakandungan);
					} else {
						$datakandungan = array('herbal_id' => $id, 'kandungan_kimia_ekstrak' => $value);
						$this->db->insert('herbal_kimia_ekstrak', $datakandungan);
					}
				}
			}
		}

		if(count($hiddencacahan) >0) {
			foreach ($cacahan as $key => $value) {
				if(trim($value) != '') {
					if($hiddencacahan[$key] != '') {
						$datakandungan = array( 'cacahan' => $value);
						$this->db->where('id', $hiddencacahan[$key]);
						$this->db->update('herbal_cacahan', $datakandungan);
					} else {
						$datacacahan = array('herbal_id' => $id, 'cacahan' => $value);
						$this->db->insert('herbal_cacahan', $datacacahan);
					}
				}
			}
		}

		if(count($hiddenkromatografi) >0) {
			foreach ($fasegerak as $key => $value) {
				if(trim($value) != '') {
					if($hiddenkromatografi[$key] != '') {
						$datakromatografi = array(
				 					  'fasegerak' => $value,
									  'fasediam' => $fasediam[$key],
									  'larutanuji' => $larutanuji[$key],
									  'larutanpembanding' => $larutanpembanding[$key],
									  'volumepenotolan' => $volumepenotolan[$key], 
									  'deteksi' => $deteksi[$key]);
						if(!empty($_FILES['gambarklt']['name'][$key])){
					      			 	// Define new $_FILES array - $_FILES['file']
					          $_FILES['file']['name'] = $_FILES['gambarklt']['name'][$key];
					          $_FILES['file']['type'] = $_FILES['gambarklt']['type'][$key];
					          $_FILES['file']['tmp_name'] = $_FILES['gambarklt']['tmp_name'][$key];
					          $_FILES['file']['error'] = $_FILES['gambarklt']['error'][$key];
					          $_FILES['file']['size'] = $_FILES['gambarklt']['size'][$key];


					          // Set preference
					          $config['upload_path'] = './images/'; 
					          $config['allowed_types'] = 'jpg|jpeg|png|gif';
					          $config['max_size'] = '5000'; // max_size in kb
					          $config['encrypt_name'] = true;
					          $config['file_name'] = $_FILES['gambarklt']['name'][$key];
					 
					          //Load upload library
					          $this->load->library('upload',$config); 

					           // File upload
					          if($this->upload->do_upload('file')){
					            // Get data about the file
					            $uploadData = $this->upload->data();
					            $filename = $uploadData['file_name'];
					            $datakromatografi['filename'] = $filename;
					           }
			  			 }


						$this->db->where('id', $hiddenkromatografi[$key]);
						$this->db->update('herbal_kromatografi', $datakromatografi);
					} else {
						$datakromatografi = array('herbal_id' => $id,
				 					  'fasegerak' => $value,
									  'fasediam' => $fasediam[$key],
									  'larutanuji' => $larutanuji[$key],
									  'larutanpembanding' => $larutanpembanding[$key],
									  'volumepenotolan' => $volumepenotolan[$key], 
									  'deteksi' => $deteksi[$key]);
									// Count total files
			      		$countfiles = count($gambarklt);
			 
			      		// Looping all files
			  			 if(!empty($_FILES['gambarklt']['name'][$key])){
					      			 	// Define new $_FILES array - $_FILES['file']
					          $_FILES['file']['name'] = $_FILES['gambarklt']['name'][$key];
					          $_FILES['file']['type'] = $_FILES['gambarklt']['type'][$key];
					          $_FILES['file']['tmp_name'] = $_FILES['gambarklt']['tmp_name'][$key];
					          $_FILES['file']['error'] = $_FILES['gambarklt']['error'][$key];
					          $_FILES['file']['size'] = $_FILES['gambarklt']['size'][$key];


					          // Set preference
					          $config['upload_path'] = './images/'; 
					          $config['allowed_types'] = 'jpg|jpeg|png|gif';
					          $config['max_size'] = '5000'; // max_size in kb
					          $config['encrypt_name'] = true;
					          $config['file_name'] = $_FILES['gambarklt']['name'][$key];
					 
					          //Load upload library
					          $this->load->library('upload',$config); 

					           // File upload
					          if($this->upload->do_upload('file')){
					            // Get data about the file
					            $uploadData = $this->upload->data();
					            $filename = $uploadData['file_name'];
					            $datakromatografi['filename'] = $filename;
					           }
			  			 }


						$this->db->insert('herbal_kromatografi', $datakromatografi);
					}
				}
			}
		}
		
	}

	public function addherbal($data, $kandungan, $kandungankimia, $kandungankimiaekstrak, $cacahan,  $fasegerak, $fasediam,$larutanuji, $larutanpembanding, $volumepenotolan, $deteksi, $gambarklt) {
		$this->db->insert('herbal', $data);
		$lastid = $this->db->insert_id();

		foreach ($kandungan as $key => $value) {
			if(trim($value) != '') {
				$datakandungan = array('herbal_id' => $lastid, 'kandungan' => $value);
				$this->db->insert('herbal_kandungan', $datakandungan);
			}
		}

		foreach ($kandungankimia as $key => $value) {
			if(trim($value) != '') {
				$datakandungankimia = array('herbal_id' => $lastid, 'kandungan_kimia_simplisia' => $value);
				$this->db->insert('herbal_kimia_simplisia', $datakandungankimia);
			}
		}

		foreach ($kandungankimiaekstrak as $key => $value) {
			if(trim($value) != '') {
				$datakandungankimiaekstrak = array('herbal_id' => $lastid, 'kandungan_kimia_ekstrak' => $value);
				$this->db->insert('herbal_kimia_ekstrak', $datakandungankimiaekstrak);
			}
		}

		foreach ($cacahan as $key => $value) {
			if(trim($value) != '') {
				$datacacahan = array('herbal_id' => $lastid, 'cacahan' => $value);
				$this->db->insert('herbal_cacahan', $datacacahan);
			}
		}

		foreach ($fasegerak as $key => $value) {
			$datakromatografi = array('herbal_id' => $lastid,
				 					  'fasegerak' => $value,
									  'fasediam' => $fasediam[$key],
									  'larutanuji' => $larutanuji[$key],
									  'larutanpembanding' => $larutanpembanding[$key],
									  'volumepenotolan' => $volumepenotolan[$key], 
									  'deteksi' => $deteksi[$key]);

			// Count total files
      		$countfiles = count($gambarklt);
 
      		// Looping all files
  			 if(!empty($_FILES['gambarklt']['name'][$key])){
		      			 	// Define new $_FILES array - $_FILES['file']
		          $_FILES['file']['name'] = $_FILES['gambarklt']['name'][$key];
		          $_FILES['file']['type'] = $_FILES['gambarklt']['type'][$key];
		          $_FILES['file']['tmp_name'] = $_FILES['gambarklt']['tmp_name'][$key];
		          $_FILES['file']['error'] = $_FILES['gambarklt']['error'][$key];
		          $_FILES['file']['size'] = $_FILES['gambarklt']['size'][$key];


		          // Set preference
		          $config['upload_path'] = './images/'; 
		          $config['allowed_types'] = 'jpg|jpeg|png|gif';
		          $config['max_size'] = '5000'; // max_size in kb
		          $config['encrypt_name'] = true;
		          $config['file_name'] = $_FILES['gambarklt']['name'][$key];
		 
		          //Load upload library
		          $this->load->library('upload',$config); 

		           // File upload
		          if($this->upload->do_upload('file')){
		            // Get data about the file
		            $uploadData = $this->upload->data();
		            $filename = $uploadData['file_name'];
		            $datakromatografi['filename'] = $filename;
		           }
  			 }


			$this->db->insert('herbal_kromatografi', $datakromatografi);
		}

		return $lastid;

	}

}
?>
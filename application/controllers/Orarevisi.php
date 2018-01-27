<?php 
class Orarevisi extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_data');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}
	function index(){
		$this->load->model('m_data');
		$this->load->view('index1');	
	}
	function tambah_dataset(){
		$this->load->model('m_data');
		$this->load->view('tambah_dataset');	
	}
	function proses_tambah_dataset(){
		$fileName = $this->input->post('file', TRUE);

  		$config['upload_path'] = './assets/file/'; 
  		$config['file_name'] = $fileName;
  		$config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
  		$config['max_size'] = 10000;

  		$this->load->library('upload', $config);
  		$this->upload->initialize($config); 
  
  		if (!$this->upload->do_upload('file')) {
   			$error = array('error' => $this->upload->display_errors());
   			$this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
   			redirect('orarevisi/tambah_dataset'); 
  		} else {
   			$media = $this->upload->data();
   			$inputFileName = 'assets/file/'.$media['file_name'];
   
   			try {
    			$inputFileType = IOFactory::identify($inputFileName);
    			$objReader = IOFactory::createReader($inputFileType);
    			$objPHPExcel = $objReader->load($inputFileName);
   				} catch(Exception $e) {
    			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
   				}

   			$sheet = $objPHPExcel->getSheet(0);
   			$highestRow = $sheet->getHighestRow();
   			$highestColumn = $sheet->getHighestColumn();

   			for ($row = 1; $row <= $highestRow; $row++){  
     		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
       		NULL,
       		TRUE,
       		FALSE);
			   $str=strtolower($rowData[0][0]);
			   $str = str_replace("'", "", $str);
			   $str = str_replace("-", "", $str);
			   $str = str_replace(")", "", $str);
			   $str = str_replace("(", "", $str);
			   $str = str_replace("=", "", $str);
			   $str = str_replace(".", "", $str);
			   $str = str_replace(",", "", $str);
			   $str = str_replace(":", "", $str);
			   $str = str_replace(";", "", $str);
			   $str = str_replace("!", "", $str);
			   $str = str_replace("?", "", $str);
			   $str = str_replace("&", "", $str);
			   $str = str_replace("/", "", $str);
			   $judul=strtolower($str);
			   $token=(explode(" ",$judul));
			   $jumlah_token=count($token);
			   for ($st=0; $st < $jumlah_token ; $st++) { 
				   $where = array('kata' => $token[$st]);
				   $stoplist = $this->m_data->edit_data($where,'tbl_stoplist')->num_rows();
				   if ($stoplist>0) {
					   $judul = str_replace($token[$st], "", $judul);
				   }
			   }
			   $judul = str_replace("       " , " ", $judul);
			   $judul = str_replace("      " , " ", $judul);
			   $judul = str_replace("     " , " ", $judul);
			   $judul = str_replace("    " , " ", $judul);
			   $judul = str_replace("   " , " ", $judul);
			   $judul = str_replace("  " , " ", $judul);
			   $judul = trim($judul);
			   $cluster=$rowData[0][1];
			   $data = array("judul"=> $judul,
			   				"cluster"=> $cluster
					);
			   $this->db->insert("tbl_data_training",$data);
   		} 
        redirect('orarevisi');
	}
	}
	function proses_stoplist(){
		$this->load->model('m_data');
		$str=$this->input->post('judul');	
		$str = str_replace("'", "", $str);
		$str = str_replace("-", "", $str);
		$str = str_replace(")", "", $str);
		$str = str_replace("(", "", $str);
		$str = str_replace("=", "", $str);
		$str = str_replace(".", "", $str);
		$str = str_replace(",", "", $str);
		$str = str_replace(":", "", $str);
		$str = str_replace(";", "", $str);
		$str = str_replace("!", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("/", "", $str);
		$judul=strtolower($str);
		$token=(explode(" ",$judul));
		$jumlah_token=count($token);
		for ($st=0; $st < $jumlah_token ; $st++) { 
			$where = array('kata' => $token[$st]);
			$stoplist = $this->m_data->edit_data($where,'tbl_stoplist')->num_rows();
			if ($stoplist>0) {
				$judul = str_replace($token[$st], "", $judul);
			}
		}
		$judul = str_replace("       " , " ", $judul);
		$judul = str_replace("      " , " ", $judul);
		$judul = str_replace("     " , " ", $judul);
		$judul = str_replace("    " , " ", $judul);
		$judul = str_replace("   " , " ", $judul);
		$judul = str_replace("  " , " ", $judul);
		$judul = trim($judul); 
		$w=array('id_bobot'=>1);
		$data = array(
				"judul"=> $str,
				"judul_preprocessing"=>$judul
		);
		$this->m_data->proses_edit_data($w,$data,"tbl_bobot");
		redirect('nbc/proses_klasifikasi');
	}
	function hasil_perhitungan(){
		$this->load->model('m_data');
		$where=array('id_bobot'=>"1");
		$wc1=array('cluster'=>"1");
		$wc2=array('cluster'=>"2");
		$wc3=array('cluster'=>"3");
		$wc4=array('cluster'=>"4");
		$data['bobot']=$this->m_data->edit_data($where,'tbl_bobot')->result();
		$data['jumlah_token'] = $this->m_data->tampil_data('tbl_data_training')->result();
		$data['cek_judul']=$this->m_data->edit_data($wc1,'tbl_data_training')->result();
		$data['cek_judul2']=$this->m_data->edit_data($wc2,'tbl_data_training')->result();
		$data['cek_judul3']=$this->m_data->edit_data($wc3,'tbl_data_training')->result();
		$data['cek_judul4']=$this->m_data->edit_data($wc4,'tbl_data_training')->result();
		$this->load->view('perhitungan',$data);	
	}
	function tambah_kata_kerja(){
		$this->load->model('m_data');
		$this->load->view('tambah_kata');	
	}
	function tambah_stoplist(){
		$this->load->model('m_data');
		$this->load->view('tambah_stoplist');	
	}
	function proses_tambah_stoplist(){
		$fileName = $this->input->post('file', TRUE);

  		$config['upload_path'] = './assets/file/'; 
  		$config['file_name'] = $fileName;
  		$config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
  		$config['max_size'] = 10000;

  		$this->load->library('upload', $config);
  		$this->upload->initialize($config); 
  
  		if (!$this->upload->do_upload('file')) {
   			$error = array('error' => $this->upload->display_errors());
   			$this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
   			redirect('orarevisi/tambah_kata_indo'); 
  		} else {
   			$media = $this->upload->data();
   			$inputFileName = 'assets/file/'.$media['file_name'];
   
   			try {
    			$inputFileType = IOFactory::identify($inputFileName);
    			$objReader = IOFactory::createReader($inputFileType);
    			$objPHPExcel = $objReader->load($inputFileName);
   				} catch(Exception $e) {
    			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
   				}

   			$sheet = $objPHPExcel->getSheet(0);
   			$highestRow = $sheet->getHighestRow();
   			$highestColumn = $sheet->getHighestColumn();

   			for ($row = 1; $row <= $highestRow; $row++){  
     		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
       		NULL,
       		TRUE,
       		FALSE);
			$lower=strtolower($rowData[0][0]);
            $token=(explode(" ", $lower));
			$jumlah_token=count($token);
			for ($i=0; $i < $jumlah_token ; $i++) { 
				$where1 = array('kata' => $token[$i]);
				$jumlah_data = $this->m_data->edit_data($where1,"tbl_stoplist")->num_rows();
				if ($jumlah_data==0) {
					$data = array(
						"kata"=> $token[$i]
						);
						$this->db->insert("tbl_stoplist",$data);
				}	
			}
   		} 
        redirect('orarevisi');
	}
	}	
	function proses(){
		$this->load->model('m_data');
		$str = $this->input->post('str');
		$lower=strtolower($str);//lowercase case folding
		$kalimat=(explode(". ",$lower));// memcah string berdasarkan enter
		$jumlah=count($kalimat);
		$paragraf="";
		for ($j=0; $j < $jumlah ; $j++) {
			$kalimat_proses[$j]="";
			$token_titik=(explode(" ",$kalimat[$j]));//tokenisasi
			$jumlah_token_titik=count($token_titik);//menghitung jumlah array dalam explode token titik
			for ($k=0; $k < $jumlah_token_titik ; $k++){
				if($k==0){
					$huruf_awal=substr($token_titik[$k],0,1);
					$huruf_selanjutnya=substr($token_titik[$k],1);
					$upper=strtoupper($huruf_awal);
					$token_titik[$k]=$upper.$huruf_selanjutnya;
					$jml_char=strlen($token_titik[$k]);
					for($a=0; $a<$jml_char; $a++ ){
						$ambil_char=substr($token_titik[$k], $a,1);
						if ($ambil_char==".") {//percabangan mencocokan dengan titik "."
							$cn=$a+1;
							$char_next=substr($token_titik[$k], $cn,1);//mengambil karakter setelah titik
							if (preg_match('/[a-z]+/i',$char_next)) {//cocokan karakter setelah titik huruf atau bukan
								$ambil_kalimat=substr($token_titik[$k], 0,$a);//ambil kalimat sebelum titik
								$kalimat_next=substr($token_titik[$k], $cn);//ambil kalimat setelah titik
								$huruf_awal_b=substr($kalimat_next,0,1);
								$huruf_selanjutnya_b=substr($kalimat_next,1);
								$upperb=strtoupper($huruf_awal_b);
								$kata_baru=$upperb.$huruf_selanjutnya_b;
								$token_titik[$k]=$ambil_kalimat."."." ".$kata_baru." ";
							}
						}
					}
					$kalimat_proses[$j]=$kalimat_proses[$j].$token_titik[$k]." ";
				}
				else{
					$jml_char=strlen($token_titik[$k]);
					for($a=0; $a<$jml_char; $a++ ){
						$ambil_char=substr($token_titik[$k], $a,1);
						if ($ambil_char==".") {//percabangan mencocokan dengan titik "."
							$cn=$a+1;
							$char_next=substr($token_titik[$k], $cn,1);//mengambil karakter setelah titik
							if (preg_match('/[a-z]+/i',$char_next)) {//cocokan karakter setelah titik huruf atau bukan
								$ambil_kalimat=substr($token_titik[$k], 0,$a);//ambil kalimat sebelum titik
								$kalimat_next=substr($token_titik[$k], $cn);//ambil kalimat setelah titik
								$huruf_awal_b=substr($kalimat_next,0,1);
								$huruf_selanjutnya_b=substr($kalimat_next,1);
								$upperb=strtoupper($huruf_awal_b);
								$kata_baru=$upperb.$huruf_selanjutnya_b;
								$token_titik[$k]=$ambil_kalimat."."." ".$kata_baru." ";
							}
						}
					}
					$kalimat_proses[$j]=$kalimat_proses[$j].$token_titik[$k]." ";
				}
			}
			$paragraf=$paragraf.$kalimat_proses[$j]."."." ";
		}
		$table='tbl_paragraf';
		$where=array('id'=>1);
		$data = array(
			'paragraf_awal'=>$str,
			'paragraf_akhir'=>$paragraf
			);
		$this->m_data->proses_edit_data($where,$data,$table);
		$data['index'] = $this->m_data->tampil_data('tbl_paragraf')->result();
		$this->load->view('index2',$data);	
	}
	
}
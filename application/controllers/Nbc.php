<?php
require APPPATH . "../assets/nbc/autoload.php";//memangil fungsi naive bayes @aziz: 13/01/2018
class Nbc extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_data');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    function proses_klasifikasi(){
        $tokenizer = new HybridLogic\Classifier\Basic;
        $classifier = new HybridLogic\Classifier($tokenizer);

        $data['data_training'] = $this->m_data->tampil_data('tbl_data_training')->result();
        foreach($data['data_training'] as $dt){
        $classifier->train($dt->cluster, $dt->judul);
        }
        $data['judul'] = $this->m_data->tampil_data('tbl_bobot')->result();
        foreach ($data['judul'] as $j) 
        $str=$j->judul;	
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
        $groups = $classifier->classify($judul);
        //Akhir Inversed Document Frequency (IDF)
		$w=array('id_bobot'=>1);
		$data_edit = array(
				"judul"=> $str,
				"judul_preprocessing"=>$judul
		);
		$data['hasil']=$groups;
		$this->m_data->proses_edit_data($w,$data_edit,"tbl_bobot");
        $data['bobot']=$this->m_data->edit_data($w,'tbl_bobot')->result();
		$this->load->view('perhitungan',$data);	
    }
}
?>
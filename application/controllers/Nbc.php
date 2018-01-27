<?php
class Nbc extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_data');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    function tambah_data_training_nbc(){
        $this->load->model('m_data');
        $data['jumlah_token'] = $this->m_data->tampil_data('tbl_data_training')->result();
        foreach($data['jumlah_token'] as $sw){
            $judul_sw=$sw->judul;
            $token_stopwords=(explode(" ", $judul_sw));
            $jumlah_token_stopwords=count($token_stopwords);
            for ($st=0; $st < $jumlah_token_stopwords ; $st++) { 
                $where = array('kata' => $token_stopwords[$st]);
                $stoplist = $this->m_data->edit_data($where,'tbl_stoplist')->num_rows();
                if ($stoplist>0) {
                    $judul_sw = str_replace($token_stopwords[$st] , "", $judul_sw);
                }
            }
            $judul_sw = str_replace("     " , " ", $judul_sw);
            $judul_sw = str_replace("    " , " ", $judul_sw);
            $judul_sw = str_replace("   " , " ", $judul_sw);
            $judul_sw = str_replace("  " , " ", $judul_sw);
            $data = array(
                    "judul"=> $judul_sw,
                    "cluster"=>$sw->cluster
            );
            $this->db->insert("tbl_data_training_nbc",$data);
        }
        //redirect('nbc/hapus_spasi');
    }
    function hitung_nbc_cluster1(){
        $this->load->model('m_data');
        $jumlah_token_semua=0;
        $data['jumlah_token'] = $this->m_data->tampil_data('tbl_data_training')->result();
        //hitung jumlah token di table data training
        foreach($data['jumlah_token'] as $jt){
            $token_jt=(explode(" ",$jt->judul));
            $jumlah_token_jt=count($token_jt);
            $jumlah_token_semua=$jumlah_token_semua+$jumlah_token_jt;
        }
        $where = array('id_bobot' => 1);
        $data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
        foreach($data['bobot'] as $b){
            $token=(explode(" ",$b->judul_preprocessing));
            $jumlah_token=count($token);}
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) { 
                $where1 = array('cluster' => 1);
                $cek_judul[1] = $this->m_data->edit_data($where1,"tbl_data_training")->result();
                $bobot=0;
                foreach($cek_judul[1] as $c1){
                    $token_training1=(explode(" ",$c1->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot=$bobot+1;
                        }
                        else{
                            $bobot=$bobot+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot);
            }
            $jumlah_array2=count($nilai_muncul);
            for ($k=0; $k < $jumlah_array2 ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                }
            }
            $jumlah_array1=count($cluster1);
            $nilai_cluster0=1;
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $nilai_cluster1= $nilai_cluster1*$cluster1[$l];
                $nilai_cluster0=$nilai_cluster0*0.000001;
            }
            if($nilai_cluster1==$nilai_cluster0){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $w=array('id_bobot'=>1);
            $data = array("nbc1"=> $nilai_cluster1
            );
            $this->m_data->proses_edit_data($w,$data,"tbl_bobot");
            redirect('nbc/hitung_nbc_cluster2');
        }
    function hitung_nbc_cluster2(){
        $this->load->model('m_data');
        $jumlah_token_semua=0;
        $data['jumlah_token'] = $this->m_data->tampil_data('tbl_data_training')->result();
        //hitung jumlah token di table data training
        foreach($data['jumlah_token'] as $jt){
            $token_jt=(explode(" ",$jt->judul));
            $jumlah_token_jt=count($token_jt);
            $jumlah_token_semua=$jumlah_token_semua+$jumlah_token_jt;
        }
        $where = array('id_bobot' => 1);
        $data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
        foreach($data['bobot'] as $b)
            $token=(explode(" ",$b->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) { 
                $where1 = array('cluster' => 2);
                $cek_judul[1] = $this->m_data->edit_data($where1,"tbl_data_training")->result();
                $bobot=0;
                foreach($cek_judul[1] as $c1){
                    $token_training1=(explode(" ",$c1->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot=$bobot+1;
                        }
                        else{
                            $bobot=$bobot+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot);
            }
            for ($k=0; $k < $jumlah_token ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                }
            }
            $nilai_cluster0=1;
            for ($l=0; $l < $jumlah_token ; $l++) {
                $nilai_cluster1=  $nilai_cluster1*$cluster1[$l];
                $nilai_cluster0=$nilai_cluster0*0.000001;
            }
            if($nilai_cluster1==$nilai_cluster0){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $w=array('id_bobot'=>1);
            $data = array("nbc2"=> $nilai_cluster1
            );
            $this->m_data->proses_edit_data($w,$data,"tbl_bobot");
            redirect('nbc/hitung_nbc_cluster3');
    }
    function hitung_nbc_cluster3(){
        $this->load->model('m_data');
        $jumlah_token_semua=0;
        $data['jumlah_token'] = $this->m_data->tampil_data('tbl_data_training')->result();
        //hitung jumlah token di table data training
        foreach($data['jumlah_token'] as $jt){
            $token_jt=(explode(" ",$jt->judul));
            $jumlah_token_jt=count($token_jt);
            $jumlah_token_semua=$jumlah_token_semua+$jumlah_token_jt;
        }
        $where = array('id_bobot' => 1);
        $data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
        foreach($data['bobot'] as $b)
            $token=(explode(" ",$b->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) { 
                $where1 = array('cluster' => 3);
                $cek_judul[1] = $this->m_data->edit_data($where1,"tbl_data_training")->result();
                $bobot=0;
                foreach($cek_judul[1] as $c1){
                    $token_training1=(explode(" ",$c1->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot=$bobot+1;
                        }
                        else{
                            $bobot=$bobot+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot);
            }
            for ($k=0; $k < $jumlah_token ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                }
            }
            $nilai_cluster0=1;
            for ($l=0; $l < $jumlah_token ; $l++) {
                $nilai_cluster1=  $nilai_cluster1*$cluster1[$l];
                $nilai_cluster0=$nilai_cluster0*0.000001;
            }
            if($nilai_cluster1==$nilai_cluster0){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }                            
            $w=array('id_bobot'=>1);
            $data = array("nbc3"=> $nilai_cluster1
            );
            $this->m_data->proses_edit_data($w,$data,"tbl_bobot");
            redirect('nbc/hitung_nbc_cluster4');
    }
    function hitung_nbc_cluster4(){
        $this->load->model('m_data');
        $jumlah_token_semua=0;
        $data['jumlah_token'] = $this->m_data->tampil_data('tbl_data_training')->result();
        //hitung jumlah token di table data training
        foreach($data['jumlah_token'] as $jt){
            $token_jt=(explode(" ",$jt->judul));
            $jumlah_token_jt=count($token_jt);
            $jumlah_token_semua=$jumlah_token_semua+$jumlah_token_jt;
        }
        $where = array('id_bobot' => 1);
        $data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
        foreach($data['bobot'] as $b)
            $token=(explode(" ",$b->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) { 
                $where1 = array('cluster' => 4);
                $cek_judul[1] = $this->m_data->edit_data($where1,"tbl_data_training")->result();
                $bobot=0;
                foreach($cek_judul[1] as $c1){
                    $token_training1=(explode(" ",$c1->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot=$bobot+1;
                        }
                        else{
                            $bobot=$bobot+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot);
            }
            for ($k=0; $k < $jumlah_token ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                }
            }
            $nilai_cluster0=1;
            for ($l=0; $l < $jumlah_token ; $l++) {
                $nilai_cluster1=  $nilai_cluster1*$cluster1[$l];
                $nilai_cluster0=$nilai_cluster0*0.000001;
            }
            if($nilai_cluster1==$nilai_cluster0){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $w=array('id_bobot'=>1);
            $data = array("nbc4"=> $nilai_cluster1
            );
            $this->m_data->proses_edit_data($w,$data,"tbl_bobot");
            redirect('orarevisi/hasil_perhitungan');
        }
}
?>
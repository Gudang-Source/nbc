<?php
class Bobot extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_data');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    function proses_perhitungan_bobot1(){
        $this->load->model('m_data');
        $where = array('id_bobot' => 1);
			$data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
            foreach($data['bobot'] as $b)
            $token=(explode(" ",$b->judul_preprocessing));
            $jumlah_token=count($token);
            $bobot1=0;
            $judul_df = array();
        for ($k=0; $k < $jumlah_token ; $k++) { 
			$where1 = array('cluster' => 1);
            $cek_judul[1] = $this->m_data->edit_data($where1,"tbl_data_training")->result();
			foreach($cek_judul[1] as $c1){
                $c1->judul;
                $c=$c1->id_data_training;
				$token_training1=(explode(" ",$c1->judul));
                $jumlah_token_training1=count($token_training1);
                $cek_df=0;
				for ($d=0; $d < $jumlah_token_training1 ; $d++) { 
					if ($token_training1[$d]==$token[$k]) {
                        $bobot1=$bobot1+1;
                        $cek_df=$cek_df+1;
                        
					}
					else {
						$bobot1=$bobot1+0;
                        $cek_df=$cek_df+0;
						}
                }
                if ($cek_df>0) {
                    array_push($judul_df,$c);
                    $judul_df=array_unique($judul_df);
                }
            }
        }
        //perhitungan bobot Term Frequency (tf)
        if($bobot1==0){
            $tf = 0;
        }
        else{
            $tf = 1 + log($bobot1);
        }
        // akhir perhitungan Term Frequency (tf)
        //Inversed Document Frequency (IDF)
        $where1 = array('cluster' => 1);
        $jumlah_data = $this->m_data->edit_data($where1,"tbl_data_training")->num_rows();
        $df=count($judul_df);
        if($df==0){
            $idf = 0 ;
        }
        else{
            $idf = log($jumlah_data/$df);
        }
        //Akhir Inversed Document Frequency (IDF)
        $w=array('id_bobot'=>1);
        $data = array("bobot1"=> $bobot1,
                    "tf1"=>$tf,
                    "df1"=>$df,
                    "idf1"=>$idf
    
        );
		$this->m_data->proses_edit_data($w,$data,"tbl_bobot");
		redirect('bobot/proses_perhitungan_bobot2');
        }	
        function proses_perhitungan_bobot2(){
            $this->load->model('m_data');
            $where = array('id_bobot' => 1);
                $data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
                foreach($data['bobot'] as $b)
                $token=(explode(" ",$b->judul_preprocessing));
                $jumlah_token=count($token);
                $bobot2=0;
                $judul_df = array();
            for ($k=0; $k < $jumlah_token ; $k++) { 
                $where2 = array('cluster' => 2);
                $cek_judul[2] = $this->m_data->edit_data($where2,"tbl_data_training")->result();
                foreach($cek_judul[2] as $c2){
                    $c2->judul;
                    $c=$c2->id_data_training;
                    $token_training2=(explode(" ",$c2->judul));
                    $jumlah_token_training2=count($token_training2);
                    $cek_df=0;
                    for ($d=0; $d < $jumlah_token_training2 ; $d++) { 
                        if ($token_training2[$d]==$token[$k]) {
                            $bobot2=$bobot2+1;
                            $cek_df=$cek_df+1;
                        }
                        else {
                            $bobot2=$bobot2+0;
                            $cek_df=$cek_df+0;
                            }
                    }
                    if ($cek_df>0) {
                        array_push($judul_df,$c);
                        $judul_df=array_unique($judul_df);
                    }
                }
            }
            //perhitungan bobot Term Frequency (tf)
            if($bobot2==0){
                $tf = 0;
            }
            else{
                $tf = 1 + log($bobot2);
            }
            // akhir perhitungan Term Frequency (tf)
            //Inversed Document Frequency (IDF)
            $where1 = array('cluster' => 2);
            $jumlah_data = $this->m_data->edit_data($where1,"tbl_data_training")->num_rows();
            $df=count($judul_df);
            if($df==0){
                $idf = 0 ;
            }
            else{
                $idf = log($jumlah_data/$df);
            }
            //Akhir Inversed Document Frequency (IDF)
            $w=array('id_bobot'=>1);
            $data = array("bobot2"=> $bobot2,
                        "tf2"=>$tf,
                        "df2"=>$df,
                        "idf2"=>$idf
        
            );
            $this->m_data->proses_edit_data($w,$data,"tbl_bobot");
            redirect('bobot/proses_perhitungan_bobot3');
            }    
            function proses_perhitungan_bobot3(){
                $this->load->model('m_data');
                $where = array('id_bobot' => 1);
                    $data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
                    foreach($data['bobot'] as $b)
                    $token=(explode(" ",$b->judul_preprocessing));
                    $jumlah_token=count($token);
                    $bobot3=0;
                    $judul_df = array();
                for ($k=0; $k < $jumlah_token ; $k++) { 
                    $where3 = array('cluster' => 3);
                    $cek_judul[3] = $this->m_data->edit_data($where3,"tbl_data_training")->result();
                    foreach($cek_judul[3] as $c3){
                        $c3->judul;
                        $c=$c3->id_data_training;
                        $token_training3=(explode(" ",$c3->judul));
                        $jumlah_token_training3=count($token_training3);
                        $cek_df=0;
                        for ($d=0; $d < $jumlah_token_training3 ; $d++) { 
                            if ($token_training3[$d]==$token[$k]) {
                                $bobot3=$bobot3+1;
                                $cek_df=$cek_df+1;
                            }
                            else {
                                $bobot3=$bobot3+0;
                                $cek_df=$cek_df+0;
                                }
                        }
                        if ($cek_df>0) {
                            array_push($judul_df,$c);
                            $judul_df=array_unique($judul_df);
                        }
                    }
                }
                //perhitungan bobot Term Frequency (tf)
                if($bobot3==0){
                    $tf = 0;
                }
                else{
                    $tf = 1 + log($bobot3);
                }
                // akhir perhitungan Term Frequency (tf)
                //Inversed Document Frequency (IDF)
                $where1 = array('cluster' => 3);
                $jumlah_data = $this->m_data->edit_data($where1,"tbl_data_training")->num_rows();
                $df=count($judul_df);
                if($df==0){
                    $idf = 0 ;
                }
                else{
                    $idf = log($jumlah_data/$df);
                }
                //Akhir Inversed Document Frequency (IDF)
                $w=array('id_bobot'=>1);
                $data = array("bobot3"=> $bobot3,
                            "tf3"=>$tf,
                            "df3"=>$df,
                            "idf3"=>$idf
            
                );
                $this->m_data->proses_edit_data($w,$data,"tbl_bobot");
                redirect('bobot/proses_perhitungan_bobot4');
                }        
    function proses_perhitungan_bobot4(){
        $this->load->model('m_data');
        $where = array('id_bobot' => 1);
			$data['bobot'] = $this->m_data->edit_data($where,"tbl_bobot")->result();
			foreach($data['bobot'] as $b)
            $token=(explode(" ",$b->judul_preprocessing));
            $jumlah_token=count($token);
            $bobot4=0;
            $judul_df = array();
        for ($k=0; $k < $jumlah_token ; $k++) { 
			$where4 = array('cluster' => 4);
			$cek_judul[4] = $this->m_data->edit_data($where4,"tbl_data_training")->result();
			foreach($cek_judul[4] as $c4){
                $c4->judul;
                $c=$c4->id_data_training;
				$token_training4=(explode(" ",$c4->judul));
                $jumlah_token_training4=count($token_training4);
                $cek_df=0;
				for ($d=0; $d < $jumlah_token_training4 ; $d++) { 
					if ($token_training4[$d]==$token[$k]) {
                        $bobot4=$bobot4+1;
                        $cek_df=$cek_df+1;
					}
					else {
						$bobot4=$bobot4+0;
                        $cek_df=$cek_df+0;
						}
                }
            
                if ($cek_df>0) {
                    array_push($judul_df,$c);
                    $judul_df=array_unique($judul_df);
                }
            }
        }
        //perhitungan bobot Term Frequency (tf)
        if($bobot4==0){
            $tf = 0;
        }
        else{
            $tf = 1 + log($bobot4);
        }
        // akhir perhitungan Term Frequency (tf)
        //Inversed Document Frequency (IDF)
        $where1 = array('cluster' => 4);
        $jumlah_data = $this->m_data->edit_data($where1,"tbl_data_training")->num_rows();
        $df=count($judul_df);
        if($df==0){
            $idf = 0 ;
        }
        else{
            $idf = log($jumlah_data/$df);
        }
        //Akhir Inversed Document Frequency (IDF)
        $w=array('id_bobot'=>1);
        $data = array("bobot4"=> $bobot4,
                    "tf4"=>$tf,
                    "df4"=>$df,
                    "idf4"=>$idf
    
        );
		$this->m_data->proses_edit_data($w,$data,"tbl_bobot");
		redirect('nbc/hitung_nbc_cluster1');
		}	
}

?>
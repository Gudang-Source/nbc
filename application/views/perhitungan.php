<!DOCTYPE html>
<html>
<head>
<title>TA 2</title>
</head>
<body>
<?php
foreach ($bobot as $a) {}
?>
<h1>HASIL PERHITUNGAN</h1>
        <p>Judul : <?php echo $a->judul ?></p><br>
        <p>Judul Preprocessing: <?php echo $a->judul_preprocessing ?></p><br>
        <?php
        $jumlah=$a->tf1+$a->tf2+$a->tf3+$a->tf4;
        $p1=($a->tf1/$jumlah)*100;
        $pp1=number_format($p1,2);
        $p2=($a->tf2/$jumlah)*100;
        $pp2=number_format($p2,2);
        $p3=($a->tf3/$jumlah)*100;
        $pp3=number_format($p3,2);
        $p4=($a->tf4/$jumlah)*100;
        $pp4=number_format($p4,2);
        $nbc1=number_format($a->nbc1,50);
        $nbc2=number_format($a->nbc2,50);
        $nbc3=number_format($a->nbc3,50);
        $nbc4=number_format($a->nbc4,50);
        ?>
        <table border = 1>
        <tr>
                <th>Konsentrasi</th>
                <th>Bobot</th>
                <th>TF</th>
                <th>DF</th>
                <th>IDF</th>
                <th>Persentase</th>
        </tr>
        <tr>
                <td>SISTEM INFORMASI DAN REKAYASA PERANGKAT LUNAK</td>
                <td><?php echo "$a->bobot1" ?></td>
                <td><?php echo "$a->tf1" ?></td>
                <td><?php echo "$a->df1" ?></td>
                <td><?php echo "$a->idf1" ?></td>
                <td><?php echo "$pp1 %" ?></td>
        </tr>
        <tr>
                <td>GRAFIKA DAN MULTIMEDIA</td>
                <td><?php echo "$a->bobot2" ?></td>
                <td><?php echo "$a->tf2" ?></td>
                <td><?php echo "$a->df2" ?></td>
                <td><?php echo "$a->idf2" ?></td>
                <td><?php echo "$pp2 %" ?></td>
        </tr>
        <tr>
                <td>SISTEM DAN JARINGAN KOMPUTER</td>
                <td><?php echo "$a->bobot3" ?></td>
                <td><?php echo "$a->tf3" ?></td>
                <td><?php echo "$a->df3" ?></td>
                <td><?php echo "$a->idf3" ?></td>
                <td><?php echo "$pp3 %" ?></td>
        </tr>
        <tr>
                <td>KOMPUTASI DAN SISTEM CERDAS</td>
                <td><?php echo "$a->bobot4" ?></td>
                <td><?php echo "$a->tf4" ?></td>
                <td><?php echo "$a->df4" ?></td>
                <td><?php echo "$a->idf4" ?></td>
                <td><?php echo "$pp4 %" ?></td>
        </tr>
        </table>
        <h2>Hasil Naive Bayes Classification</h2>
        <table border =1>
        <tr>
           <th>SISTEM INFORMASI DAN REKAYASA PERANGKAT LUNAK</th>
           <th>GRAFIKA DAN MULTIMEDIA</th>
           <th>SISTEM DAN JARINGAN KOMPUTER</th>
           <th>KOMPUTASI DAN SISTEM CERDAS</th>
        </tr>
        <tr>
            <td><?php
                if ($a->nbc1>$a->nbc2 and $a->nbc1>$a->nbc3 and $a->nbc1>$a->nbc4) {
                        echo "<font color=blue><b>$nbc1</b></font>";
                }
                elseif($a->nbc1<$a->nbc2 and $a->nbc1<$a->nbc3 and $a->nbc1<$a->nbc4){
                        echo "<font color=red><b>$nbc1</b></font>";
                }
                else{
                        echo "$nbc1"; 
                }
                ?></td>
            <td><?php
                if ($a->nbc2>$a->nbc1 and $a->nbc2>$a->nbc3 and $a->nbc2>$a->nbc4) {
                        echo "<font color=blue><b>$nbc2</b></font>";
                }
                elseif ($a->nbc2<$a->nbc1 and $a->nbc2<$a->nbc3 and $a->nbc2<$a->nbc4) {
                        echo "<font color=red><b>$nbc2</b></font>";
                }
                else{
                        echo "$nbc2"; 
                }
                ?></td>
            <td><?php
                if ($a->nbc3>$a->nbc1 and $a->nbc3>$a->nbc2 and $a->nbc3>$a->nbc4) {
                        echo "<font color=blue><b>$nbc3</b></font>";
                }
                elseif ($a->nbc3<$a->nbc1 and $a->nbc3<$a->nbc2 and $a->nbc3<$a->nbc4) {
                        echo "<font color=red><b>$nbc3</b></font>";
                }
                else{
                        echo "$nbc3"; 
                }
                ?></td>
            <td><?php
                if ($a->nbc4>$a->nbc1 and $a->nbc4>$a->nbc2 and $a->nbc4>$a->nbc3) {
                        echo "<font color=blue><b>$nbc4</b></font>";
                }
                elseif ($a->nbc4<$a->nbc1 and $a->nbc4<$a->nbc2 and $a->nbc4<$a->nbc3) {
                        echo "<font color=red><b>$nbc4</b></font>";
                }
                else{
                        echo "$nbc4"; 
                }
                ?></td>
        </tr>
        <tr>
            <td>
        <?php
        //NBC1
        $jumlah_token_semua=0;
        //hitung jumlah token di table data training
        foreach($jumlah_token as $jt){
            $token_jt=(explode(" ",$jt->judul));
            $jumlah_token_jt=count($token_jt);
            $jumlah_token_semua=$jumlah_token_semua+$jumlah_token_jt;
        }
        foreach ($bobot as $a) {
            $token=(explode(" ",$a->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) {
                $bobot1=0;
                foreach ($cek_judul as $cj){
                    $token_training1=(explode(" ",$cj->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot1=$bobot1+1;
                        }
                        else{
                            $bobot1=$bobot1+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot1);
            }
            echo "<h2>Proses Perhitungan Cluster 1</h2>";
            echo "<h3> Nilai Muncul Token</h3>";
            for ($i=0; $i < $jumlah_token ; $i++) {
                echo "$token[$i] = <b>$nilai_muncul[$i]</b>";
                echo "<br>";
            }
            echo "<h3> Nilai Token</h3>";
            $jumlah_array2=count($nilai_muncul);
            for ($k=0; $k < $jumlah_array2 ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{    
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                    echo "Nilai token $token[$k] = ($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua) hasilnya = <b>$cluster1[$k]</b><br> ";
                }
            }
            echo "<h3> Nilai NBC CLUSTER 1</h3>";
            $jumlah_array1=count($cluster1);
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $nilai_cluster1= $nilai_cluster1*$cluster1[$l];
            }
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $clus1=number_format($cluster1[$l],50);
                echo"$clus1 * ";
            }
            echo"0.25 <b>(0.25 di dapat dari 1 per jumlah cluster)</b><br>";
            if($nilai_cluster1==1){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $nbc1=number_format($nilai_cluster1,50);
            echo "dari rincian di atas maka nilai NBC : <b>$nbc1</b>";
        }
        ?>
            </td>
            <td>
        <?php
        //NBC2
        foreach ($bobot as $a) {
            $token=(explode(" ",$a->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) {
                $bobot1=0;
                foreach ($cek_judul2 as $cj){
                    $token_training1=(explode(" ",$cj->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot1=$bobot1+1;
                        }
                        else{
                            $bobot1=$bobot1+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot1);
            }
            echo "<h2>Proses Perhitungan Cluster 2</h2>";
            echo "<h3> Nilai Muncul Token</h3>";
            for ($i=0; $i < $jumlah_token ; $i++) {
                echo "$token[$i] = <b>$nilai_muncul[$i]</b>";
                echo "<br>";
            }
            echo "<h3> Nilai Token</h3>";
            $jumlah_array2=count($nilai_muncul);
            for ($k=0; $k < $jumlah_array2 ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{    
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                    echo "Nilai token $token[$k] = ($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua) hasilnya = <b>$cluster1[$k]</b><br> ";
                }
            }
            echo "<h3> Nilai NBC CLUSTER 2</h3>";
            $jumlah_array1=count($cluster1);
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $nilai_cluster1= $nilai_cluster1*$cluster1[$l];
            }
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $clus1=number_format($cluster1[$l],50);
                echo"$clus1 * ";
            }
            echo"0.25 <b>(0.25 di dapat dari 1 per jumlah cluster)</b><br>";
            if($nilai_cluster1==1){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $nbc1=number_format($nilai_cluster1,50);
            echo "dari rincian di atas maka nilai NBC : <b>$nbc1</b>";
        }
        ?>
            </td>
            <td>
        <?php
        //NBC3
        foreach ($bobot as $a) {
            $token=(explode(" ",$a->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) {
                $bobot1=0;
                foreach ($cek_judul3 as $cj){
                    $token_training1=(explode(" ",$cj->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot1=$bobot1+1;
                        }
                        else{
                            $bobot1=$bobot1+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot1);
            }
            echo "<h2>Proses Perhitungan Cluster 3</h2>";
            echo "<h3> Nilai Muncul Token</h3>";
            for ($i=0; $i < $jumlah_token ; $i++) {
                echo "$token[$i] = <b>$nilai_muncul[$i]</b>";
                echo "<br>";
            }
            echo "<h3> Nilai Token</h3>";
            $jumlah_array2=count($nilai_muncul);
            for ($k=0; $k < $jumlah_array2 ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{    
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                    echo "Nilai token $token[$k] = ($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua) hasilnya = <b>$cluster1[$k]</b><br> ";
                }
            }
            echo "<h3> Nilai NBC CLUSTER 3</h3>";
            $jumlah_array1=count($cluster1);
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $nilai_cluster1= $nilai_cluster1*$cluster1[$l];
            }
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $clus1=number_format($cluster1[$l],50);
                echo"$clus1 * ";
            }
            echo"0.25 <b>(0.25 di dapat dari 1 per jumlah cluster)</b><br>";
            if($nilai_cluster1==1){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $nbc1=number_format($nilai_cluster1,50);
            echo "dari rincian di atas maka nilai NBC : <b>$nbc1</b>";
        }
        ?>
            </td>
            <td>
        <?php
        //NBC4
        //hitung jumlah token di table data training
        foreach ($bobot as $a) {
            $token=(explode(" ",$a->judul_preprocessing));
            $jumlah_token=count($token);
            $nilai_muncul=array();
            $cluster1=array();
            $jumlah_token_cluster1=0;
            $nilai_cluster1=1;
            for ($i=0; $i < $jumlah_token ; $i++) {
                $bobot1=0;
                foreach ($cek_judul4 as $cj){
                    $token_training1=(explode(" ",$cj->judul));
                    $jumlah_token_training1=count($token_training1);
                    $jumlah_token_cluster1=$jumlah_token_cluster1+$jumlah_token_training1;
                    for ($j=0; $j < $jumlah_token_training1 ; $j++) { 
                        if ($token_training1[$j]==$token[$i]) {
                            $bobot1=$bobot1+1;
                        }
                        else{
                            $bobot1=$bobot1+0;
                        }
                    }
                }
                array_push($nilai_muncul,$bobot1);
            }
            echo "<h2>Proses Perhitungan Cluster 4</h2>";
            echo "<h3> Nilai Muncul Token</h3>";
            for ($i=0; $i < $jumlah_token ; $i++) {
                echo "$token[$i] = <b>$nilai_muncul[$i]</b>";
                echo "<br>";
            }
            echo "<h3> Nilai Token</h3>";
            $jumlah_array2=count($nilai_muncul);
            for ($k=0; $k < $jumlah_array2 ; $k++) { 
                if ($nilai_muncul[$k]==0) {
                    $cluster1[$k]=0.000001;
                }
                else{    
                    $cluster1[$k]=($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua);
                    echo "Nilai token $token[$k] = ($nilai_muncul[$k]+1)/($jumlah_token_cluster1+$jumlah_token_semua) hasilnya = <b>$cluster1[$k]</b><br> ";
                }
            }
            echo "<h3> Nilai NBC CLUSTER 4</h3>";
            $jumlah_array1=count($cluster1);
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $nilai_cluster1= $nilai_cluster1*$cluster1[$l];
            }
            for ($l=0; $l < $jumlah_array1 ; $l++) {
                $clus1=number_format($cluster1[$l],50);
                echo"$clus1 * ";
            }
            echo"0.25 <b>(0.25 di dapat dari 1 per jumlah cluster)</b><br>";
            if($nilai_cluster1==1){
                $nilai_cluster1=0;//supaya yang bobotnya no tidak paling besar
            }
            else{
                $nilai_cluster1=$nilai_cluster1*(1/4);
            }
            $nbc1=number_format($nilai_cluster1,50);
            echo "dari rincian di atas maka nilai NBC : <b>$nbc1</b>";
        }
        ?>
            </td>
        </tr>
        </table>
        <h1>Note : </h1>
        <p>Kesalahan nilai naive bayes karena jika ada cluster yang mempunyai bobot lebih dari dua maka yang bobotnya terkecil yang akan menjadi terbesar karena perkalihan desimalnya lebih sedikit</p>
</body>
</html>
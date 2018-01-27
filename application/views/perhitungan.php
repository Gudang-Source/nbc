<!DOCTYPE html>
<html>
<head>
<title>TA Library</title>
</head>
<body>
<?php
//foreach ($hasil as $h) {}
foreach ($bobot as $a) {}
?>
<h1>HASIL PERHITUNGAN</h1>
        <p>Judul : <?php echo $a->judul ?></p><br>
        <p>Judul Preprocessing: <?php echo $a->judul_preprocessing ?></p><br>
        <table border = 1>
        <tr>
                <th>Konsentrasi</th>
                <th>Nilai NBC</th>
        </tr>
        <tr>
                <td>JARINGAN DAN KEAMANAN KOMPUTER</td>
                <?php
                if($hasil[1]>$hasil[2] and $hasil[1]>$hasil[3] and $hasil[1]>$hasil[4] and $hasil[1]>$hasil[5] and $hasil[1]>$hasil[6]){
                        echo "<td><font color='blue'><b>$hasil[1]</b></font></td>";
                }
                else{
                        echo "<td>$hasil[1]</td>";   
                }
                ?>
        </tr>
        <tr>
                <td>INFORMATIKA TEORI DAN SISTEM CERDAS</td>
                <?php
                if($hasil[2]>$hasil[1] and $hasil[2]>$hasil[3] and $hasil[2]>$hasil[4] and $hasil[2]>$hasil[5] and $hasil[2]>$hasil[6]){
                        echo "<td><font color='blue'><b>$hasil[2]</b></font></td>";
                }
                else{
                        echo "<td>$hasil[2]</td>";   
                }
                ?>
        </tr>
        <tr>
                <td>REKAYASA PERANGKAT LUNAK</td>
                <?php
                if($hasil[3]>$hasil[1] and $hasil[3]>$hasil[2] and $hasil[3]>$hasil[4] and $hasil[3]>$hasil[5] and $hasil[3]>$hasil[6]){
                        echo "<td><font color='blue'><b>$hasil[3]</b></font></td>";
                }
                else{
                        echo "<td>$hasil[3]</td>";   
                }
                ?>
        </tr>
        <tr>
                <td>MULTIMEDIA</td>
                <?php
                if($hasil[4]>$hasil[1] and $hasil[4]>$hasil[2] and $hasil[4]>$hasil[3] and $hasil[4]>$hasil[5] and $hasil[4]>$hasil[6]){
                        echo "<td><font color='blue'><b>$hasil[4]</b></font></td>";
                }
                else{
                        echo "<td>$hasil[4]</td>";   
                }
                ?>
        </tr>
        <tr>
                <td>SISTEM INFORMASI</td>
                <?php
                if($hasil[5]>$hasil[1] and $hasil[5]>$hasil[2] and $hasil[5]>$hasil[3] and $hasil[5]>$hasil[6] and $hasil[5]>$hasil[4]){
                        echo "<td><font color='blue'><b>$hasil[6]</b></font></td>";
                }
                else{
                        echo "<td>$hasil[5]</td>";   
                }
                ?>
        </tr>
        <tr>
                <td>INFORMATIKA MEDIS</td>
                <?php
                if($hasil[6]>$hasil[1] and $hasil[6]>$hasil[2] and $hasil[6]>$hasil[3] and $hasil[6]>$hasil[5] and $hasil[6]>$hasil[6]){
                        echo "<td><font color='blue'><b>$hasil[6]</b></font></td>";
                }
                else{
                        echo "<td>$hasil[6]</td>";   
                }
                ?>
        </tr>
        </table>
</body>
</html>
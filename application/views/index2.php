<!DOCTYPE html>
<html>
<head>
<title>Ora Revisi</title>
</head>
<body>
<?php
foreach ($index as $i) {}
?>
<h1>Paragraf Awal</h1>
    <table>
        <td><?php echo $i->paragraf_awal ?></td>
    </table>
    <br>
    <h1>Hasil Revisi</h1>
    <table>
        <td><?php echo $i->paragraf_akhir ?></td>
    </table>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<title>TA 2</title>
</head>
<body>

<h1>Klasifikasi Judul</h1>
<p>Naive Bayes clasification</p>
<a href="<?php echo base_url("index.php/orarevisi/tambah_dataset_nbc"); ?>">tambah dataset nbc</a> |
<a href="<?php echo base_url("index.php/orarevisi/tambah_stoplist"); ?>">tambah stoplist</a> | <a href="<?php echo base_url("index.php/orarevisi/tambah_dataset"); ?>">Tambah Data Konsentrasi</a> 
<form action="<?php echo base_url("index.php/orarevisi/proses_stoplist"); ?>" method="post" novalidate>
    <label>Masukan Judul</label><br>
    <input name="judul" type="text">
    <button type="submit">Submit</button>
</form>
</body>
</html>
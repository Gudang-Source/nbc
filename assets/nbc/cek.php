<?php echo '<pre>';

include './autoload.php';
include 'koneksi.php';


$tokenizer = new HybridLogic\Classifier\Basic;
$classifier = new HybridLogic\Classifier($tokenizer);

$datatraining = mysqli_query($koneksi, "SELECT * from tbl_data_training");
foreach ($datatraining as $row){
    $classifier->train($row['cluster'], $row['judul']);
}

$groups = $classifier->classify('Aplikasi Game Whack The Monster ! Berbasis Android

');
var_dump($groups);
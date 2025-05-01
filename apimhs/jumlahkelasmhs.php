<?php
    require_once 'koneksi.php';

    //string utk query
    $sql = "SELECT KELAS, COUNT(*) as Jumlah FROM TMahasiswa GROUP BY KELAS";

    //jalankan query
    $run = mysqli_query($conn, $sql);

    //buat array utk simpan hasil
    $result = array();

    //baca data dari hasil/$run, lalu simpan ke array
    while($row = mysqli_fetch_array($run)){
        array_push($result, array(
            "Kelas"=>$row['KELAS'],
            "Jumlah Mahasiswa"=>$row['Jumlah']
        ));
    }
    //encode ke json dan tampilkan
    echo json_encode($result);
    //tutup koneksi
    mysqli_close($conn);
?>
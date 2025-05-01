<?php
    require_once 'koneksi.php';

    //string utk query
    $sql = "SELECT * FROM TMatakuliah ORDER BY KdMataKuliah ASC";

    //jalankan query
    $run = mysqli_query($conn, $sql);

    //buat array utk simpan hasil
    $result = array();

    //baca data dari hasil/$run, lalu simpan ke array
    while($row = mysqli_fetch_array($run)){
        array_push($result, array(
            "Kode MataKuliah"=>$row['KdMataKuliah'],
            "MataKuliah"=>$row['MataKuliah'],
        ));
    }
    //encode ke json dan tampilkan
    echo json_encode($result);
    //tutup koneksi
    mysqli_close($conn);
?>
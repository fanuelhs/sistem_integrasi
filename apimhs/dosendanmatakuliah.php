<?php
    require_once 'koneksi.php';

    //string utk query
    // $sql = "SELECT * FROM TDosen ORDER BY KdDosen ASC";
    $sql = "SELECT TDosen.KdDosen, TDosen.NamaDosen, TDosen.kdMatKul, TMatakuliah.KdMataKuliah, TMatakuliah.MataKuliah
            FROM TDosen
            INNER JOIN TMatakuliah
            ON TDosen.kdMatKul = TMatakuliah.KdMataKuliah
            ORDER BY TDosen.KdDosen ASC";

    //jalankan query
    $run = mysqli_query($conn, $sql);

    //buat array utk simpan hasil
    $result = array();

    //baca data dari hasil/$run, lalu simpan ke array
    while($row = mysqli_fetch_array($run)){
        array_push($result, array(
            "Kode Dosen"=>$row['KdDosen'],
            "Nama Dosen"=>$row['NamaDosen'],
            "Kode MataKuliah"=>$row['kdMatKul'],
            "Nama MataKuliah"=>$row['MataKuliah']
        ));
    }
    //encode ke json dan tampilkan
    echo json_encode($result);
    //tutup koneksi
    mysqli_close($conn);
?>
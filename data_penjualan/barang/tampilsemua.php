<?php
    require_once '..\koneksi.php';
 
    //string untuk query
    $sql = "SELECT * FROM barang ORDER BY idbarang ASC";

    //JALANKAN QUERY
    $r = mysqli_query($conn,$sql);

    //SIMPAN KE ARRAY
    $result = array();

    while($row = mysqli_fetch_array($r)){
        array_push($result, array(
            "idbarang"=>$row['idbarang'],
            "namabarang"=>$row['namabarang'],
            "hrgsatuan"=>$row['hrgsatuan'],
            "idsuplier"=>$row['idsuplier']
        ));
    }
    echo json_encode($result);
    mysqli_close($conn);
?>
<?php
    require_once '..\koneksi.php';
 
    //string untuk query
    $sql = "SELECT * FROM supplier_data ORDER BY idsuplier ASC";

    //JALANKAN QUERY
    $r = mysqli_query($conn,$sql);

    //SIMPAN KE ARRAY
    $result = array();

    while($row = mysqli_fetch_array($r)){
        array_push($result, array(
            "idsuplier"=>$row['idsuplier'],
            "namasuplier"=>$row['namasuplier'],
            "kota"=>$row['kota']
        ));
    }
    echo json_encode($result);
    mysqli_close($conn);
?>
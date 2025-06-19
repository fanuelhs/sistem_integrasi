<?php
    require_once '..\koneksi.php';
 
    //string untuk query
    $sql = "SELECT * FROM customer ORDER BY customerID ASC";

    //JALANKAN QUERY
    $r = mysqli_query($conn,$sql);

    //SIMPAN KE ARRAY
    $result = array();

    while($row = mysqli_fetch_array($r)){
        array_push($result, array(
            "customerid"=>$row['customerID'],
            "namacustomer"=>$row['namaCustomer'],
            "kota"=>$row['kota'],
            "jenisusaha"=>$row['jenususaha']
        ));
    }
    echo json_encode($result);
    mysqli_close($conn);
?>
<?php
    require_once '..\koneksi.php';
 
    //string untuk query
    $sql = "SELECT * FROM penjualan_1 ORDER BY notransaksi ASC";

    //JALANKAN QUERY
    $r = mysqli_query($conn,$sql);

    //SIMPAN KE ARRAY
    $result = array();

    while($row = mysqli_fetch_array($r)){
        array_push($result, array(
            "notransaksi"=>$row['notransaksi'],
            "tanggal"=>$row['tanggal'],
            "customerid"=>$row['customerID'],
            "grandtotal"=>$row['grandtotal']
        ));
    }
    echo json_encode($result);
    mysqli_close($conn);
?>
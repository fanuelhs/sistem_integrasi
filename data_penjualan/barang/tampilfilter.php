<?php
    require_once '..\koneksi.php';
 
    //FILTER DATA MHS PER NIM (id)
    $id = $_GET['id'];

    //string untuk query
    $sql = "SELECT * FROM barang
            WHERE idbarang = '$id'
            ORDER BY idbarang ASC";

    //JALANKAN QUERY
   
    if (mysqli_query($conn,$sql)) {
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

        return array("status" => "success", "message" => "Data Ada");
    } else {
        return array("status" => "error", "message" => "Error: " . mysqli_error($conn));
    }
 
    mysqli_close($conn);
?>
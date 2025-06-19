<?php
    require_once '..\koneksi.php';
 
    //FILTER DATA MHS PER NIM (id)
    $id = $_GET['id'];

    //string untuk query
    $sql = "SELECT * FROM supplier_data
            WHERE idsuplier = '$id'
            ORDER BY idsuplier ASC";

    //JALANKAN QUERY
   
    if (mysqli_query($conn,$sql)) {
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

        return array("status" => "success", "message" => "Data Ada");
    } else {
        return array("status" => "error", "message" => "Error: " . mysqli_error($conn));
    }
 
    mysqli_close($conn);
?>
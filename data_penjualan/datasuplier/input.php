<?php
require_once '..\koneksi.php';

function inputData($idsuplier, $namasuplier, $kota,  $conn) {
    $response = array();

    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    $sql = "INSERT INTO supplier_data (idsuplier, namasuplier, kota) 
            VALUES ('$idsuplier', '$namasuplier', '$kota')";

    if (mysqli_query($conn, $sql)) {
        $response['status'] = 'success';
        $response['message'] = 'Data berhasil dimasukkan';
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    return $response;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['idsuplier']) && isset($_POST['namasuplier']) && isset($_POST['kota'])) {
        $idsuplier = $_POST['idsuplier'];
        $namasuplier = $_POST['namasuplier'];
        $kota = $_POST['kota'];

        $result = inputData($idsuplier, $namasuplier, $kota, $conn);
    } else {
        $result = array(
            'status' => 'error',
            'message' => 'Data input tidak lengkap'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($result);
}

mysqli_close($conn);
?>

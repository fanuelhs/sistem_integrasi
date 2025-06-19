<?php
require_once '..\koneksi.php';

function inputData($idbarang, $namabarang, $hrgsatuan, $idsuplier, $conn) {
    $response = array();

    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    $sql = "INSERT INTO barang (idbarang, namabarang, hrgsatuan, idsuplier) 
            VALUES ('$idbarang', '$namabarang', '$hrgsatuan', '$idsuplier')";

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
    if(isset($_POST['idbarang']) && isset($_POST['namabarang']) && isset($_POST['hrgsatuan']) && isset($_POST['idsuplier'])) {
        $idbarang = $_POST['idbarang'];
        $namabarang = $_POST['namabarang'];
        $hrgsatuan = $_POST['hrgsatuan'];
        $idsuplier = $_POST['idsuplier'];

        $result = inputData($idbarang, $namabarang, $hrgsatuan, $idsuplier,  $conn);
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

<?php
require_once '..\koneksi.php';

function inputData($notransaksi, $idbarang, $qty, $totalperbarang, $conn) {
    $response = array();

    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    $sql = "INSERT INTO detilpenjualan (notransaksi, idbarang, qty, totalperbarang) 
            VALUES ('$notransaksi', '$idbarang', '$qty', '$totalperbarang')";

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
    if(isset($_POST['notransaksi']) && isset($_POST['idbarang']) && isset($_POST['qty']) && isset($_POST['totalperbarang'])) {
        $notransaksi = $_POST['notransaksi'];
        $idbarang = $_POST['idbarang'];
        $qty = $_POST['qty'];
        $totalperbarang = $_POST['totalperbarang'];

        $result = inputData($notransaksi, $idbarang, $qty, $totalperbarang,  $conn);
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

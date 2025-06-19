<?php
require_once '..\koneksi.php';

function inputData($notransaksi, $tanggal, $customerid, $grandtotal, $conn) {
    $response = array();

    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    $sql = "INSERT INTO penjualan_1 (notransaksi, tanggal, customerID, grandtotal) 
            VALUES ('$notransaksi', '$tanggal', '$customerid', '$grandtotal')";

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
    if(isset($_POST['notransaksi']) && isset($_POST['tanggal']) && isset($_POST['customerID']) && isset($_POST['grandtotal'])) {
        $notransaksi = $_POST['notransaksi'];
        $tanggal = $_POST['tanggal'];
        $customerid = $_POST['customerID'];
        $grandtotal = $_POST['grandtotal'];

        $result = inputData($notransaksi, $tanggal, $customerid, $grandtotal,  $conn);
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

<?php
require_once '..\koneksi.php';

function inputData($customerid, $namacustomer, $kota, $jenisusaha, $conn) {
    $response = array();

    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    $sql = "INSERT INTO customer (customerID, namaCustomer, kota, jenususaha) 
            VALUES ('$customerid', '$namacustomer', '$kota', '$jenisusaha')";

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
    if(isset($_POST['customerID']) && isset($_POST['namaCustomer']) && isset($_POST['kota']) && isset($_POST['jenususaha'])) {
        $customerid = $_POST['customerID'];
        $namacustomer = $_POST['namaCustomer'];
        $kota = $_POST['kota'];
        $jenisusaha = $_POST['jenususaha'];

        $result = inputData($customerid, $namacustomer, $kota, $jenisusaha,  $conn);
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

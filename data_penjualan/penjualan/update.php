<?php
require_once '..\koneksi.php';

function updateData($notransaksi, $tanggal, $customerid, $grandtotal, $conn) {
    $response = array();

    //cek koneksi
    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    //proses query
    $sql = "UPDATE penjualan_1 SET tanggal='$tanggal', 
                customerID='$customerid', 
                grandtotal='$grandtotal' WHERE notransaksi='$notransaksi'";
    //jalankan query

    if (mysqli_query($conn, $sql)) {
        //jika sukses, / jika terdapat row/record yang berubah
        if (mysqli_affected_rows($conn) > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Data berhasil diperbarui';
        } else { //jika 
            $response['status'] = 'error';
            $response['message'] = 'Tidak ada data yang diperbarui';
        }

    } else { //jika gagal
        $response['status'] = 'error';
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    return $response;
}


if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);
    if(isset($put_vars['notransaksi']) && 
        isset($put_vars['tanggal']) && 
            isset($put_vars['customerID']) &&
                isset($put_vars['grandtotal'])) {
            
                //Jika Data input form sudah lengkap dan parameter benar maka
                //simpan hasil PUT value ke var masing2
                $notransaksi = $put_vars['notransaksi'];
                $tanggal = $put_vars['tanggal'];
                $customerid = $put_vars['customerID'];
                $grandtotal = $put_vars['grandtotal'];
        
        //call function UpdateData, hasillnya disimpan di array $result
        $result = updateData($notransaksi, $tanggal, $customerid, $grandtotal, $conn);
    } else {
        //jika ada parameter yang tidak lengkap / salah identifikasi
        $result = array(
            'status' => 'error',
            'message' => 'Parameter/Data input tidak lengkap'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($result);

} else {
    echo json_encode(array
    ("status" => "error", "message" => "Invalid request method"));
}

//tutup koneksi
mysqli_close($conn);
?>
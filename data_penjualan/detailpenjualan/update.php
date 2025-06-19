<?php
require_once '..\koneksi.php';

function updateData($notransaksi, $idbarang, $qty, $totalperbarang, $conn) {
    $response = array();

    //cek koneksi
    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }

    //proses query
    $sql = "UPDATE detilpenjualan SET idbarang='$idbarang', 
                qty='$qty', 
                totalperbarang='$totalperbarang' WHERE notransaksi='$notransaksi'";
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
        isset($put_vars['idbarang']) && 
            isset($put_vars['qty']) &&
                isset($put_vars['totalperbarang'])) {
            
                //Jika Data input form sudah lengkap dan parameter benar maka
                //simpan hasil PUT value ke var masing2
                $notransaksi = $put_vars['notransaksi'];
                $idbarang = $put_vars['idbarang'];
                $qty = $put_vars['qty'];
                $totalperbarang = $put_vars['totalperbarang'];
        
        //call function UpdateData, hasillnya disimpan di array $result
        $result = updateData($notransaksi, $idbarang, $qty, $totalperbarang, $conn);
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
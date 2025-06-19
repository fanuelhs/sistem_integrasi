<?php
require_once '..\koneksi.php';

function deleteData($notransaksi, $conn) {
    $response = array();

    //cek koneksi
    if(!$conn){
        $response['status'] = 'error';
        $response['message'] = "KONEKSI GAGAL: " . mysqli_connect_error();
        return $response;
    }
    //proses query menghapus data cabang
    $sql1 = "DELETE FROM detilpenjualan WHERE notransaksi='$notransaksi'";
    mysqli_query($conn, $sql1);

    //proses query
    $sql = "DELETE FROM penjualan_1 WHERE notransaksi='$notransaksi'";
    //jalankan query
    if (mysqli_query($conn, $sql)) {
        //jika sukses, / jika terdapat row/record yang terhapus
        if (mysqli_affected_rows($conn) > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Data berhasil dihapus';
        } else { //jika tidak ada data yang terhapus
            $response['status'] = 'error';
            $response['message'] = 'Tidak ada data yang dihapus';
        }
    } else { //jika gagal
        $response['status'] = 'error';
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    return $response;
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $delete_vars);
    if(isset($delete_vars['notransaksi'])) {
        //Jika Data input sudah lengkap dan parameter benar
        $notransaksi = $delete_vars['notransaksi'];
        
        //call function deleteData, hasilnya disimpan di array $result
        $result = deleteData($notransaksi, $conn);
    } else {
        //jika parameter tidak lengkap / salah identifikasi
        $result = array(
            'status' => 'error',
            'message' => 'Parameter notransaksi tidak ditemukan'
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
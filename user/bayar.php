<?php
include '../koneksi.php';
session_start();

if (isset($_POST['tambah'])) {
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $nama = $_POST['petugas']; 
    $total = $_POST['total'];
    
    $user_id = $_SESSION['user_id'];
    
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $jumlah_kembalian = $jumlah_bayar - $total;

    if (!empty($produk) && !empty($jumlah) && !empty($jumlah_bayar)) {
        if ($total <= $jumlah_bayar) {
            $sql = mysqli_query($db, "INSERT INTO tb_transaksi (product_id, user_id, transaksi_jumlah, transaksi_total, jumlah_bayar, jumlah_kembalian, transaksi_tanggal, jam_bayar) 
                                      VALUES ('$produk', '$user_id', '$jumlah', '$total', '$jumlah_bayar', '$jumlah_kembalian', NOW(), NOW())");
            echo "<script>
                    alert('Pembayaran berhasil terkirim');
                    window.location.href='../user.php?page=user/transaksi.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Maaf, uang pembayaran kurang');
                    window.location.href='insertpembayaran.php?id=$user_id';
                  </script>"; 
        }
    } else {
        echo "<script>
                alert('Gagal terkirim, pastikan semua data terisi dengan benar');
                window.location.href='insertpembayaran.php?id=$user_id';
              </script>";
    }
}
?>

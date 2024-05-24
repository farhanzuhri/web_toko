<?php
include '../koneksi.php';
session_start();

if (isset($_GET['transaksi_id'])) {
    $transaksi_id = $_GET['transaksi_id'];
    
    // Perbaiki query untuk mengambil data transaksi
    $sql = mysqli_query($db, "SELECT * FROM tb_transaksi 
                              JOIN tb_product ON tb_transaksi.product_id = tb_product.product_id 
                              JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id 
                              WHERE transaksi_id = '$transaksi_id'");
    $ambil_data = mysqli_fetch_assoc($sql);

        $produk = $ambil_data['product_name'];
        $product_price = $ambil_data['product_price'];
        $nama = $ambil_data['nama'];
        $transaksi_tanggal = $ambil_data['transaksi_tanggal'];
        $jam_bayar = $ambil_data['jam_bayar'];
        $transaksi_jumlah = $ambil_data['transaksi_jumlah'];
        $transaksi_total = $ambil_data['transaksi_total'];
        $jumlah_bayar = $ambil_data['jumlah_bayar'];
        $jumlah_kembalian = $ambil_data['jumlah_kembalian'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pembayaran</title>
    <style>
        table {
            margin: auto;
        }
        .print {
            margin-top: 10px;
        }
        @media print {
            .print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2 align="center">OZ Shop</h2>
    <h3 align="center">Laporan Produk</h3>
    <br>
    <table>
        <tr>
            <td>Produk</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;<?= isset($produk) ? $produk : ''; ?></td>
        </tr>
        <tr>
            <td>Petugas</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;<?= isset($nama) ? $nama : ''; ?></td>
        </tr>
        <tr>
            <td>Tanggal Transaksi</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;<?= isset($transaksi_tanggal) ? $transaksi_tanggal : ''; ?></td>
        </tr>
        <tr>
            <td>Waktu Transaksi</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;<?= isset($jam_bayar) ? $jam_bayar : ''; ?></td>
        </tr>
        <tr>
            <td>Jumlah Produk</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;<?= isset($transaksi_jumlah) ? $transaksi_jumlah : ''; ?></td>
        </tr>
        <tr>
            <td>Harga Produk</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;Rp. <?= isset($product_price) ? number_format($product_price) : ''; ?></td>
        </tr>
        <tr>
            <td>Total Transaksi</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;Rp. <?= isset($transaksi_total) ? number_format($transaksi_total) : ''; ?></td>
        </tr>
        <tr>
            <td>Jumlah Bayar</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;Rp. <?= isset($jumlah_bayar) ? number_format($jumlah_bayar) : ''; ?></td>
        </tr>
        <tr>
            <td>Jumlah Kembalian</td>
            <td>&nbsp;&nbsp;&nbsp;: &nbsp;Rp. <?= isset($jumlah_kembalian) ? number_format($jumlah_kembalian) : ''; ?></td>
        </tr>
    </table>
    <a href="#" onclick="window.print();"><button class="print">CETAK</button></a>
</body>
</html>

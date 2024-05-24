<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produk']) && isset($_POST['jumlah'])) {
    $product_id = $_POST['produk'];
    $jumlah = $_POST['jumlah'];

    $sql_produk = mysqli_query($db, "SELECT * FROM tb_product JOIN tb_category ON tb_product.category_id = tb_category.category_id WHERE product_id ='$product_id'");
    $ambil_data = mysqli_fetch_assoc($sql_produk);
    $kategori = $ambil_data['category_name'];
    $produk = $ambil_data['product_name'];
    $product_price = $ambil_data['product_price'];
    $transaksi_total = $product_price * $jumlah;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../insertedit.css">
    <title>Bayar Produk</title>
</head>
<body>
    <div class="container border">
        <h1 align="center">Bayar Barang</h1>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Nama barang</b></label><br>
            <label for="exampleInputEmail1"><?= isset($produk) ? $produk : '' ?></label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Kategori Barang</b></label><br>
            <label for="exampleInputEmail1"><?= isset($kategori) ? $kategori : '' ?></label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Harga</b></label><br>
            <label for="exampleInputEmail1">Rp. <?= isset($product_price) ? number_format($product_price) : '' ?></label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Jumlah</b></label><br>
            <label for="exampleInputEmail1"><?= isset($jumlah) ? $jumlah : '' ?></label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Dengan nominal</b></label><br>
            <label for="exampleInputEmail1">Rp. <?= isset($transaksi_total) ? number_format($transaksi_total) : '' ?></label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Jumlah bayar</b></label><br>
            <form action="bayar.php" method="post">
                <input name="jumlah_bayar" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <input type="hidden" name="produk" value="<?= $product_id ?>">
                <input type="hidden" name="jumlah" value="<?= $jumlah ?>">
                <input type="hidden" name="product_price" value="<?= $product_price ?>">
                <input type="hidden" name="total" value="<?= $transaksi_total ?>">
                <input type="hidden" name="petugas" value="username_placeholder"> <!-- Sesuaikan dengan nama petugas -->
                
                <button type="submit" name="tambah" class="btn btn-primary mt-2 mb-2">Bayar</button>          
            </form>
        </div>
    </div>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/popper.js"></script> 
</body>
</html>

<div class="section">
        <div class="container-fluid px-4">
            <h3 class="text-center mt-3">Transaksi</h3>
            <div class="box">
                <div class="card mb-4 mt-3">
                    <div class="card-header">
                        <a href="admin/insertpembayaran.php"><i class="fa-solid fa-plus" style="font-size: 20px; color: green;"></i></a>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th width="60px">No</th>
                                    <th>Produk</th>
                                    <th>Petugas</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = mysqli_query($db, "SELECT * FROM tb_transaksi JOIN tb_product ON tb_transaksi.product_id = tb_product.product_id JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id ORDER by transaksi_id DESC");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo $row['nama'] ?></td>
                                            <td><?php echo $row['transaksi_jumlah'] ?></td>
                                            <?php 
                                                // Menghitung total transaksi
                                                $transaksi_total = $row['transaksi_jumlah'] * $row['product_price']; 
                                            ?>
                                            <td>Rp. <?php echo number_format($transaksi_total) ?></td>
                                            <td><?php echo $row['transaksi_tanggal'] ?></td>
                                            <td>
                                                <a href="admin/cetak.php?transaksi_id=<?php echo $row['transaksi_id'] ?>" target="blank"><i class="fa-solid fa-print" name="cetak" style="font-size: 20px; color: green;">Cetak</i></a>
                                                <i class="fa-solid fa-trash-can" style="font-size: 20px; color: red;" data-bs-toggle="modal" data-bs-target="#modalhapus<?= $no ?>">Hapus</i>
                                            </td>
                                        </tr>

										<!-- Awal Modal hapus Produk -->
                                        <div class="modal fade" id="modalhapus<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Transaksi</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form enctype="multipart/form-data" action="?page=admin/transaksi.php" method="POST">
                                                            <input type="hidden" name="transaksi_id" value="<?php echo $row['transaksi_id'] ?>">
                                                            <h5 class="text-center">Apakah Anda Yakin akan Menghapus ini? <br>
                                                                <span class="text-danger"><?=$row['product_name'] ?> - Rp. <?php echo number_format($row['transaksi_total']) ?></span>    
                                                            </h5>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="bhapus" class="btn btn-danger">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal hapus Produk -->
                                <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="5">Tidak ada data</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['bubah'])) {
        $kategori = $_POST['kategori'];
        $nama_produk = $_POST['produk'];
        $harga = $_POST['harga'];
        $product_id = $_POST['product_id'];

        $sql = mysqli_query($db, "UPDATE tb_product SET 
            category_id = (SELECT category_id FROM tb_category WHERE category_name = '$kategori'),
            product_name = '$nama_produk',
            product_price = '$harga'
            WHERE product_id = '$product_id'");

        if ($sql) {
            echo "<script>alert('Update berhasil'); window.location.href = '?page=admin/produk.php';</script>";
        } else {
            echo "<script>alert('Update gagal'); window.location.href = '?page=admin/produk.php';</script>";
        }
    }
    ?>

<?php
if (isset($_POST['bhapus'])) {
    $transaksi_id = $_POST['transaksi_id'];

    $sql = mysqli_query($db, "DELETE FROM tb_transaksi WHERE transaksi_id = '$transaksi_id'");

    if ($sql) {
        echo "<script>alert('Hapus Data Berhasil'); window.location.href = '?page=admin/transaksi.php';</script>";
    } else {
        echo "<script>alert('Hapus Data Gagal'); window.location.href = '?page=admin/transaksi.php';</script>";
    }
}
?>
    

<?php
if (isset($_POST['bsimpan'])) {
    $product_id = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $nama = $_POST['petugas']; // Memperbaiki variabel $nama yang tidak terdefinisi sebelumnya
    
    // Menghitung total transaksi
    $sql_produk = mysqli_query($db, "SELECT product_price FROM tb_product WHERE product_id = '$product_id'");
    $row_produk = mysqli_fetch_array($sql_produk);
    $total = $jumlah * $row_produk['product_price'];
    
    // Memasukkan data transaksi ke dalam tabel tb_transaksi
    $sql = mysqli_query($db, "INSERT INTO tb_transaksi (product_id, user_id, transaksi_jumlah, transaksi_total, transaksi_tanggal) VALUES ('$product_id', (SELECT user_id FROM tb_user WHERE username = '$nama'), '$jumlah', '$total', NOW())");

    if ($sql) {
        echo "<script>alert('Insert berhasil'); window.location.href = '?page=admin/transaksi.php';</script>";
    } else {
        echo "<script>alert('Insert gagal'); window.location.href = '?page=admin/transaksi.php';</script>";
    }
}
?>




<div class="section">
        <div class="container-fluid px-4">
            <h3 class="text-center mt-3">Data Produk</h3>
            <div class="box">
                <div class="card mb-4 mt-4">
                    <div class="card-header">
                        <i class="fa-solid fa-plus" style="font-size: 20px; color: green;" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th width="60px">No</th>
                                    <th>Kategori</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = mysqli_query($db, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id DESC");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $row['category_name'] ?></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td>Rp. <?php echo number_format($row['product_price']) ?></td>
                                            <td>
                                                <i class="fa-solid fa-pen-to-square" style="font-size: 20px; color: green;" data-bs-toggle="modal" data-bs-target="#modalubah<?= $no ?>">Edit</i>
                                                <i class="fa-solid fa-trash-can" style="font-size: 20px; color: red;" data-bs-toggle="modal" data-bs-target="#modalhapus<?= $no ?>">Hapus</i>   
                                            </td>
                                        </tr>
                                        <!-- Awal Modal ubah Produk -->
                                        <div class="modal fade" id="modalubah<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Produk</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form enctype="multipart/form-data" action="?page=user/produk.php" method="POST">
                                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
                                                            <div class="mb-3">
                                                                <label for="kategoriSelect" class="form-label">Kategori</label>
                                                                <select name="kategori" class="form-select" id="kategoriSelect">
                                                                    <?php
                                                                    $sql_kategori = mysqli_query($db, "SELECT * FROM tb_category ORDER BY category_id DESC");
                                                                    while ($row_kategori = mysqli_fetch_array($sql_kategori)) {
                                                                        $selected = ($row_kategori['category_name'] == $row['category_name']) ? 'selected' : '';
                                                                        echo "<option value='{$row_kategori['category_name']}' $selected>{$row_kategori['category_name']}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleInputPassword1" class="form-label">Nama Produk</label>
                                                                <input name="produk" type="text" value="<?php echo $row['product_name'] ?>" class="form-control" id="exampleInputPassword1">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleInputPassword1" class="form-label">Harga</label>
                                                                <input name="harga" type="text" value="Rp. <?php echo number_format($row['product_price']) ?>" class="form-control" id="exampleInputPassword1">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="bubah" class="btn btn-primary">Ubah</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal ubah Produk -->

										<!-- Awal Modal hapus Produk -->
                                        <div class="modal fade" id="modalhapus<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Produk</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
														<form enctype="multipart/form-data" action="?page=user/produk.php" method="POST">
                                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
                                                        
														<h5 class="text-center">Apakah Anda Yakin akan Menghapus ini? <br>
														<span class="text-danger"><?=$row['category_name'] ?> - <?=$row['product_name'] ?></span>	
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
            echo "<script>alert('Update berhasil'); window.location.href = '?page=user/produk.php';</script>";
        } else {
            echo "<script>alert('Update gagal'); window.location.href = '?page=user/produk.php';</script>";
        }
    }
    ?>

	<?php
    if (isset($_POST['bhapus'])) {
        $product_id = $_POST['product_id'];

        $sql = mysqli_query($db, "DELETE FROM tb_product WHERE product_id = '$product_id'");

        if ($sql) {
            echo "<script>alert('Hapus Data Berhasil'); window.location.href = '?page=user/produk.php';</script>";
        } else {
            echo "<script>alert('Hapus Data Gagal'); window.location.href = '?page=user/produk.php';</script>";
        }
    }
    ?>
    <!-- Awal Modal Tambah Produk -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="?page=user/produk.php" method="POST">
                        <div class="mb-3">
                            <label for="kategoriSelect" class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" id="kategoriSelect">
                                <?php
                                $sql_kategori = mysqli_query($db, "SELECT * FROM tb_category ORDER BY category_id DESC");
                                while ($row_kategori = mysqli_fetch_array($sql_kategori)) {
                                    echo "<option value='{$row_kategori['category_name']}'>{$row_kategori['category_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nama Produk</label>
                            <input name="produk" type="text" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Harga</label>
                            <input name="harga" type="text" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="bsimpan" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah Produk -->

    <?php
    if (isset($_POST['bsimpan'])) {
        $kategori = $_POST['kategori'];
        $nama_produk = $_POST['produk'];
        $harga = $_POST['harga'];

        $sql = mysqli_query($db, "INSERT INTO tb_product (category_id, product_name, product_price) VALUES (
            (SELECT category_id FROM tb_category WHERE category_name = '$kategori'),
            '$nama_produk', '$harga')");

        if ($sql) {
            echo "<script>alert('Insert berhasil'); window.location.href = '?page=user/produk.php';</script>";
        } else {
            echo "<script>alert('Insert gagal'); window.location.href = '?page=user/produk.php';</script>";
        }
    }
    ?>

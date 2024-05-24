 <div class="section">
        <div class="container">
            <h3 class="text-center mt-3">Data Kategori</h3>
            <div class="box">
                <div class="card mb-4 mt-3">
                    <div class="card-header">
                    <i class="fa-solid fa-plus" style="font-size: 20px; color: green;" data-bs-toggle="modal" data-bs-target="#tambahkategori"></i>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = mysqli_query($db, "SELECT * FROM tb_category ORDER BY category_id DESC");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $row['category_name'] ?></td>
                                            <td>
                                                <i class="fa-solid fa-pen-to-square" style="font-size: 20px; color: green;" data-bs-toggle="modal" data-bs-target="#modalubah<?= $no ?>">Edit</i>
                                                <i class="fa-solid fa-trash-can" style="font-size: 20px; color: red;" data-bs-toggle="modal" data-bs-target="#modalhapus<?= $no ?>">Hapus</i>
                                            </td>
                                        </tr>
										<!-- Awal Modal ubah kategori -->
										<div class="modal fade" id="modalubah<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Kategori</h1>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
														<form enctype="multipart/form-data" action="?page=admin/kategori.php" method="POST">
															<input type="hidden" name="category_id" value="<?php echo $row['category_id'] ?>">
															<div class="mb-3">
																<label for="exampleInputPassword1" class="form-label">Kategori</label>
																<input name="kategori" type="text" value="<?php echo $row['category_name'] ?>" class="form-control" id="exampleInputPassword1" required>
															</div>
															<div class="modal-footer">
																<button type="submit" name="bubah" class="btn btn-primary">Ubah</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<!-- Akhir Modal ubah kategori -->

										<!-- Awal Modal hapus kategori -->
                                        <div class="modal fade" id="modalhapus<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Kategori</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
														<form enctype="multipart/form-data" action="?page=admin/kategori.php" method="POST">
															<input type="hidden" name="category_id" value="<?php echo $row['category_id'] ?>">
                                                        
														<h5 class="text-center">Apakah Anda Yakin akan Menghapus ini? <br>
														<span class="text-danger"><?=$row['category_name'] ?></span>	
														</h5>
															<div class="modal-footer">
                                                            	<button type="submit" name="bhapus" class="btn btn-danger">Hapus</button>
                                                        	</div>
                                                    	</form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal hapus kategori -->
                                <?php }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
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
		$category_id = $_POST['category_id'];

		$sql = mysqli_query($db, "UPDATE tb_category SET 
			category_name = '$kategori' 
			WHERE category_id = '$category_id'");

		if ($sql) {
			echo "<script>alert('Update berhasil'); window.location.href = '?page=admin/kategori.php';</script>";
		} else {
			echo "<script>alert('Update gagal'); window.location.href = '?page=admin/kategori.php';</script>";
		}
	}
	?>

	<?php
    if (isset($_POST['bhapus'])) {
        $category_id = $_POST['category_id'];

        $sql = mysqli_query($db, "DELETE FROM tb_category WHERE category_id = '$category_id'");

        if ($sql) {
            echo "<script>alert('Hapus Data Berhasil'); window.location.href = '?page=admin/kategori.php';</script>";
        } else {
            echo "<script>alert('Hapus Data Gagal'); window.location.href = '?page=admin/kategori.php';</script>";
        }
    }
    ?>

	<!-- Awal Modal Tambah kategori -->
    <div class="modal fade" id="tambahkategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="?page=admin/kategori.php" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kategori</label>
                            <input name="kategori" type="text" class="form-control" id="exampleInputPassword1" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="bsimpan" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah kategori -->

	<?php
    if (isset($_POST['bsimpan'])) {
        $kategori = $_POST['kategori'];
        
        $sql = mysqli_query($db, "INSERT INTO tb_category (category_name) VALUES ('$kategori') ");

        if ($sql) {
            echo "<script>alert('Insert berhasil'); window.location.href = '?page=admin/kategori.php';</script>";
        } else {
            echo "<script>alert('Insert gagal'); window.location.href = '?page=admin/kategori.php';</script>";
        }
    }
    ?>
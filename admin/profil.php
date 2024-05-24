<div class="col-md-12">
        <div class="container-fluid px-4">
            <div class="text-center fs-1 mt-2">Profil</div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Tambah Profil
            </button>

            <!-- Display user profiles -->
            <div class="row">
                <?php
                // Fetch user data
                $sql = mysqli_query($db, "SELECT * FROM tb_user");

                // Display user profiles
                while ($ambil_data = mysqli_fetch_assoc($sql)) {
                    $user_id = $ambil_data['user_id'];
                    $user = $ambil_data['username'];
                    $nama = $ambil_data['nama'];
                    $foto = $ambil_data['foto'];
                    $role = $ambil_data['role'];
                    $pass = isset($ambil_data['password']) ? $ambil_data['password'] : '';
                ?>
                <div class="col-md-4">
                    <div class="card mt-3" style="width: 18rem;">
                        <img src="file/<?php echo $foto; ?>" class="card-img-top" alt="User Photo">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $nama; ?></h5>
                            <p class="card-text"><?php echo $role; ?></p>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalubah<?php echo $user_id; ?>">
                                Ubah
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalhapus<?php echo $user_id; ?>">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Modal ubah profil -->
                <div class="modal fade" id="modalubah<?php echo $user_id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalubahLabel<?php echo $user_id; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalubahLabel<?php echo $user_id; ?>">Profil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data" action="?page=admin/profil.php" method="POST">
                                    <!-- Form fields for updating a profile -->
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                    <div class="mb-3">
                                        <label for="username<?php echo $user_id; ?>" class="form-label">Username</label>
                                        <input name="username" type="text" value="<?php echo $user ?>" class="form-control" id="username<?php echo $user_id; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password<?php echo $user_id; ?>" class="form-label">Password</label>
                                        <input name="password" type="password" id="password<?php echo $user_id; ?>" value="<?php echo $pass ?>" class="form-control">
                                        <input type="checkbox" onclick="togglePasswordVisibility(<?php echo $user_id; ?>)"> Lihat Password
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama<?php echo $user_id; ?>" class="form-label">Nama</label>
                                        <input name="nama" type="text" value="<?php echo $nama ?>" class="form-control" id="nama<?php echo $user_id; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto<?php echo $user_id; ?>" class="form-label">Foto</label>
                                        <input name="foto" type="file" class="form-control" id="foto<?php echo $user_id; ?>" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="role<?php echo $user_id; ?>" class="form-label">Role</label>
                                        <select class="form-select" name="role" id="role<?php echo $user_id; ?>" required>
                                            <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option>
                                            <option value="user" <?php if ($role == 'user') echo 'selected'; ?>>User</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="bubah" class="btn btn-primary">Ubah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal ubah Profil-->
                
                <!-- Modal Hapus Produk -->
                <div class="modal fade" id="modalhapus<?php echo $user_id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalhapusLabel<?php echo $user_id; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalhapusLabel<?php echo $user_id; ?>">Hapus Produk</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data" action="?page=admin/profil.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <h5 class="text-center">
                                        Apakah Anda Yakin akan Menghapus ini? <br>
                                        <span class="text-danger"><?php echo $nama; ?> - <?php echo $role; ?></span>
                                    </h5>
                                    <div class="modal-footer">
                                        <button type="submit" name="bhapus" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Hapus Produk -->
                <?php
                }
                ?>
            </div>

            <!-- PHP untuk menangani ubah dan hapus -->
            <?php
            if (isset($_POST['bhapus'])) {
                $user_id = $_POST['user_id'];
                $sql = mysqli_query($db, "DELETE FROM tb_user WHERE user_id = '$user_id'");
                if ($sql) {
                    echo "<script>alert('Hapus Data Berhasil'); window.location.href = '?page=admin/profil.php';</script>";
                } else {
                    echo "<script>alert('Hapus Data Gagal'); window.location.href = '?page=admin/profil.php';</script>";
                }
            }

            if (isset($_POST['bubah'])) {
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $nama = $_POST['nama'];
                $role = $_POST['role'];
                $user_id = $_POST['user_id'];
                $foto = '';

                // Check if a new photo is uploaded
                if ($_FILES['foto']['name']) {
                    $foto = $_FILES['foto']['name'];
                    $file_tmp = $_FILES['foto']['tmp_name'];
                    move_uploaded_file($file_tmp, 'file/' . $foto);

                    // Update user profile with the new photo
                    $sql = mysqli_query($db, "UPDATE tb_user SET 
                        username = '$user',
                        password = '$pass',
                        nama = '$nama',
                        foto = '$foto',
                        role = '$role'
                        WHERE user_id = '$user_id'");
                } else {
                    // Update user profile without changing the existing photo
                    $sql = mysqli_query($db, "UPDATE tb_user SET 
                        username = '$user',
                        password = '$pass',
                        nama = '$nama',
                        role = '$role'
                        WHERE user_id = '$user_id'");
                }

                // Redirect to the profile page after update
                if ($sql) {
                    echo "<script>alert('Update berhasil'); window.location.href = '?page=admin/profil.php';</script>";
                } else {
                    echo "<script>alert('Update gagal'); window.location.href = '?page=admin/profil.php';</script>";
                }
            }
            ?>

            <!-- Modal Tambah profil -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Profil</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form enctype="multipart/form-data" action="?page=admin/profil.php" method="POST">
                                <!-- Form fields for adding a new profile -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control" id="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input name="nama" type="text" class="form-control" id="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input name="foto" type="file" class="form-control" id="foto" accept="image/*" required>
                                </div>
                                <div class="form-check">
                                    <!-- Radio buttons for user role -->
                                    <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin">
                                    <label class="form-check-label" for="roleAdmin">
                                        Admin
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="roleUser" value="user" checked>
                                    <label class="form-check-label" for="roleUser">
                                        User
                                    </label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="bsimpan" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Tambah Profil-->
        </div>
    </div>

    <script>
        function togglePasswordVisibility(user_id) {
            var x = document.getElementById("password" + user_id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <?php
    if (isset($_POST['bsimpan'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $nama = $_POST['nama'];
        $role = $_POST['role'];
        $foto = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($file_tmp, 'file/' . $foto);

        $sql = mysqli_query($db, "INSERT INTO tb_user (username, password, foto, nama, role) VALUES ('$user', '$pass' , '$foto', '$nama', '$role')");
        if ($sql) {
            echo "<script>alert('Insert berhasil'); window.location.href = '?page=admin/profil.php';</script>";
        } else {
            echo "<script>alert('Insert gagal'); window.location.href = '?page=admin/profil.php';</script>";
        }
    }
    ?>

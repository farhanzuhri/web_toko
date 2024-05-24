<?php
    include '../koneksi.php';

    if ($_POST) {
        $product_name = $_POST['produk'];
        $category_name = $_POST['kategori'];
        // Additional processing if needed
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="../insertedit.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container border">
        <h1 align="center">Insert Produk</h1>
        <form method="post" action="insertaction.php">
            <div class="form-group">
                <label for="exampleInputEmail1"><b>Nama Barang</b></label><br>
                <select name="produk" class="form-select" id="kategoriSelect">
                    <?php
                    $sql_produk = mysqli_query($db, "SELECT * FROM tb_product ORDER BY product_id DESC");
                    while ($row_produk = mysqli_fetch_array($sql_produk)) {
                        $selected = ($row_produk['product_name'] == $row['product_name']) ? 'selected' : '';
                        echo "<option value='{$row_produk['product_id']}' $selected>{$row_produk['product_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="mt-3"><b>Jumlah Barang</b></label><br>
                <input name="jumlah" type="number" class="form-control" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary mt-2 mb-2">Insert</button>          
        </form>  
    </div>
    <script src="../assets/js/jquery.js"> </script>
    <script src="../assets/js/bootstrap.min.js"> </script>
    <script src="../assets/js/popper.js"> </script> 
</body>
</html>

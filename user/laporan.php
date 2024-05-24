<?php
$semuadata=array();
$tgl_mulai="-";
$tgl_selesai="-";
    if (isset($_POST['kirim'])) {
      $tgl_mulai = $_POST['tglm'];
      $tgl_selesai = $_POST['tgls'];
      $transaksi = mysqli_query($db, "SELECT * FROM tb_transaksi 
      JOIN tb_product ON tb_transaksi.product_id = tb_product.product_id 
      JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id WHERE transaksi_tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ");
      while($row = mysqli_fetch_array($transaksi));
    }
?>
 <div class="section">
        <div class="container">
            <h3 class="text-center mt-4">Laporan Produk</h3>
              <form method="post">
                <div class="row form-1 form">
                  <div class="col-12 col-md-6 left mb-3 mt-3">
                      <label>Tanggal Mulai</label>
                      <input type="date" class="form-control" name="tglm" value="<?php echo $tgl_mulai ?>">
                  </div>
                   <div class="col-12 col-md-6 right mb-3 mt-3">
                      <label>Tanggal Selesai</label>
                      <input type="date" class="form-control" name="tgls" value="<?php echo $tgl_selesai ?>">
                    </div>
                   <div class="col-12 col-md-6 right mb-2" style="padding: 0px 0">
                      <label>&nbsp;</label>
                      <button class="btn btn-primary" name="kirim">Lihat</button>
                  </div>
                </div>
          </form>
            <div class="box">
                <div class="card mb-4 mt-3">
                    <div class="card-header">
                    <i class="fa-solid fa-plus" style="font-size: 20px; color: green;" data-bs-toggle="modal" data-bs-target="#tambahkategori"></i>
                    </div>
                    <div class="card-body">
                    <form target="blank" action="user/cetak_laporan.php" method="post">
                        <table id="datatablesSimple" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Petugas</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Tgl bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                    $no = 1;
                    $semuadata=array();
                    $tgl_mulai="-";
                    $tgl_selesai="-";
                  if (isset($_POST['kirim'])) {
                    $tgl_mulai = $_POST['tglm'];
                    $tgl_selesai = $_POST['tgls'];

                  if (!empty($tgl_mulai) || !empty($tgl_selesai))
                    $transaksi = mysqli_query($db, "SELECT * FROM tb_transaksi 
                    JOIN tb_product ON tb_transaksi.product_id = tb_product.product_id 
                    JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id WHERE transaksi_tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER by transaksi_id DESC");
                    
                    while($row = mysqli_fetch_array($transaksi)){
                  ?>
                    <tr>
                      <th scope="row"><?php echo $no++ ?></th>
                      <td><?php echo $row['product_name'] ?></td>
                      <td><?php echo $row['nama'] ?></td>
                      <td><?php echo $row['transaksi_jumlah'] ?></td>
                      <td>Rp. <?php echo number_format($row['transaksi_total']) ?></td>
                      <td><?php echo $row['transaksi_tanggal'] ?></td>
                    </tr>
                    <?php }
                                } else {
                                ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button class="btn btn-secondary" name="cetak">Cetak</button>
               </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

	
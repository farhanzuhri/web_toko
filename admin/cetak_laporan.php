<?php
include '../koneksi.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran</title>
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        * {
            color: black;
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
    <script>
        function tableHtmlToExcel(tableID, filename = '') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
            filename = filename ? filename + '.xls' : 'excel_data.xls';
   
            downloadLink = document.createElement("a");
    
            document.body.appendChild(downloadLink);
    
            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                downloadLink.download = filename;
                downloadLink.click();
            }
        }
    </script>
</head>
<body>
<div id="tblData" class="table-responsive">
    <h1 align="center">Laporan Pembelian</h1>
    <table id="reportTable" border="1" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Produk</th>
                <th scope="col">Petugas</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total</th>
                <th scope="col">Tgl bayar</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = mysqli_query($db, "SELECT * FROM tb_transaksi 
                                      JOIN tb_product ON tb_transaksi.product_id = tb_product.product_id 
                                      JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id 
                                      ORDER BY transaksi_id DESC");
            $no = 1;
            while ($row = mysqli_fetch_array($sql)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $row['product_name'] ?></td>
                <td><?php echo $row['nama'] ?></td>
                <td><?php echo $row['transaksi_jumlah'] ?></td>
                <td>Rp. <?php echo number_format($row['transaksi_total']) ?></td>
                <td><?php echo $row['transaksi_tanggal'] ?></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
<a href="#" onclick="window.print();"><button class="print">CETAK</button></a> 
<button class="print" onclick="tableHtmlToExcel('reportTable', 'Laporan Pembelian')">Export Excel</button>
</body>
</html>

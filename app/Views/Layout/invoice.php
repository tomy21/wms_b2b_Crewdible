<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print</title>
</head>
<style>
body {
    margin: auto;
}

p {
    color: grey;
    font-size: 12px;
}

span {
    font-style: italic;
}

h3 {
    margin-bottom: 30px;
    font-size: 12px;
}

table {
    font-family: "Arial";
    font-size: 12px;
    padding: 2px 10px;

}

.table {
    border-collapse: collapse;
    font-size: 12px;
    width: 100%;
    text-align: left;
}

.table th,
.table td {
    border: 1px solid #cccccc;
    padding: 9px 21px;
}

.table th,
.table td:last-child {
    border: 1px solid #cccccc;
}

.table td:first-child {
    border: 1px solid #cccccc;
}

caption {
    caption-side: top;
    margin-bottom: 10px;
    font-size: 16px;
}

.grid {
    display: grid;
    width: 100%;
    margin: 0 auto;
    grid-template-columns: repeat(2, 33.33%);
    grid-gap: 10px;
}

.head-1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
}


/*Tabel Responsive 1*/
.table-container {
    overflow: auto;
}
</style>

<body>
    <table border="0">
        <thead>

            <img src="<?= $barcode ?>" alt="">
            <img src="<?= $barcode1 ?>" alt="" width="40px">

            <tr>
                <td width="60%">
                    <p>Tanggal Pesanan <span>(Order date)</span></p>
                    <h3 style="font-weight:bolder ;"><?= $date ?></h3>
                </td>
                <td rowspan="3" align="center">
                    <p></p>
                    <p></p>
                    <img src="./dist/img/kingkong.png" alt="" width="180px">
                </td>
            </tr>
            <tr>
                <td width="60%">
                    <p>Nomor Pesanan <span>(Order number)</span></p>
                    <h3 style="font-weight:bolder ;"><?= $noOrder ?></h3>
                </td>
            </tr>
            <tr>
                <td width="60%">
                    <p>Tanggal Pengiriman <span>(Schedule Delivery Time)</span></p>
                    <h3 style="font-weight:bolder;"><?= $drop_date ?></h3>
                </td>
            </tr>
        </thead>
    </table>
    <br>
    <hr>
    <table>
        <tr>
            <td width="40%">
                <p>Penerima <span>(Recipient)</span></p>
                <h3 style="font-weight:1000 ;"><?= $penerima ?></h3>
            </td>
            <td width="60%">
                <p>Alamat Pengiriman <span>(Delivery address)</span></p>
                <h3 style="font-weight:1000 ;"><?= $address ?></h3>
            </td>

        </tr>
        <tr>
            <td width="40%">
                <p>Nomor Telepon <span>(Phone Number)</span></p>
                <h3 style="font-weight:bolder;">+ <?= $contact ?></h3>
            </td>
            <td width="60%">
                <p>Detail Alamat <span>(Address Detail)</span></p>
                <h3 style="font-weight:bolder ;">-</h3>
            </td>
        </tr>
    </table>
    </div>


    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th width="7%">No</th>
                    <th width="47%">Nama Product <br><span
                            style="font-size:8px; font-style:italic ; color: grey; font-weight: 100;">(product
                            name)</span></th>
                    <th width="15%">SKU</th>
                    <th width="15%">Jumlah <br><span
                            style="font-size:8px; font-style:italic ; color: grey; font-weight: 100;">(Quantity)</span>
                    </th>
                    <th width="15%">Berat <br><span
                            style="font-size:8px; font-style:italic ; color: grey; font-weight: 100;">(Quantity)</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data->getResultArray() as $row) :
                ?>
                <tr>
                    <td width="7%" style="font-weight:bolder ;"><?= $no++ ?></td>
                    <td width="47%" style="font-weight:bolder ;"><?= $row['Item_detail'] ?></td>
                    <td width="15%" style="font-weight:bolder ;"><?= $row['Item_id'] ?></td>
                    <td width="15%" style="font-weight:bolder ;"><?= $row['quantity'] ?></td>
                    <td width="15%" style="font-weight:bolder ;">-</td>
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
    </div>


</body>

</html>
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
    font-size: 9px;
}

span {
    font-style: italic;
}

h3 {
    margin-bottom: 30px;
    font-size: 10px;
}

table {
    font-family: "Arial";
    font-size: 12px;
    padding: 2px 10px;

}

.table {
    border-collapse: collapse;
    font-size: 10px;
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
    <center>
        <img src="<?= $barcode ?>" alt="">
        <br><br><br><br>
        <h3 style="font-weight:2000 ; align-items: center; margin-top:100px"><?= $id_basket ?></h3>
    </center>


</body>

</html>
<link rel="stylesheet" href="<?= base_url().'/plugins/chart.js/Chart.min.css';?>">
<script src="<?= base_url().'/plugins/chart.js/Chart.bundle.min.js';?>"></script>

<canvas id="myChart" style="height:10vh; width:40vh"></canvas>

<?php 
    $tanggal = "";
    $total = "";

    foreach($grafik as $row) : 
        $tgl = $row->tgl;
        $tanggal .="'$tgl'" . ",";
        $total_qty = $row->quantity;
        $total .="'$total_qty'" . ",";
    endforeach;
?>
<script>
    var ctx  = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx,{
        type : 'bar',
        responsive : true,
        data : {
            labels : [<?= $tanggal;?>],
            datasets : [{
                label : 'Total Barang Masuk',
                backgroundColor : 'rgb(255, 99, 132)',
                borderColor : ['#333'],
                data : [<?= $total;?>]
            }],
        },
        duration : 1000
    })
</script>
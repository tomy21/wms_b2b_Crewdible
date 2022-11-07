<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>History Outbound</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>




<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <!-- <div class="row">
                <div class="col-md-3">
                    <input type="text" name="awal" id="awal" class="form-control" readonly>
                </div>
                <button class="btn btn-sm btn-info"><i class="fa fa-search"></i> filter data</button>
            </div> -->
            <br>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Warehouse</th>
                        <th>Order Id</th>
                        <th>Sum Qty Order</th>
                        <th>Sum Qty Packing</th>
                        <th>Count Items Order</th>
                        <th>Count Items Packing</th>
                        <th>Jam Slot</th>
                        <th>Selesai Packing</th>
                        <th>Selesai Handover</th>
                        <th>Keterangan</th>
                        <th>Detail</th>
                    </tr>
                </thead>


            </table>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<div class="modaledit" style="display: none;"></div>

<script>
    $(document).ready(function() {
        fetch_data()

        function fetch_data(start_date = '', end_date = '') {
            var table = $('#example1').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "order": [],
                "info": true,
                "ajax": {
                    "url": "<?php echo site_url('Handover/detailHandover') ?>",
                    "type": "POST",
                    

                },
                
                "columnDefs": [{
                    "targets": [0, 3, 4, 5, 6, 8, 9, 11],
                    "orderable": false,
                }],
            });
        }

        // $('#awal').daterangepicker({
        //     "ranges": {
        //         'Hari ini': [moment(), moment()],
        //         'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //         '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
        //         '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
        //         'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
        //     },
        //     format: 'YYYY-MM-DD'
        // }, function(start, end) {
        //     $('#example1').DataTable().destroy();

        //     fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        // });
    });


    function detail(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/Handover/dataDetail') ?>",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalDetail').modal('show');

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/Handover/editData') ?>",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modaledit').html(response.data).show();
                    $('#modaledit').modal('show');

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
</script>

<?= $this->endsection('isi'); ?>
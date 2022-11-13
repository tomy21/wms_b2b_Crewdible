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
            dom: 'lBftip', // Add the Copy, Print and export to CSV, Excel and PDF buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [{
                "targets": [0, 3, 4, 5, 6, 8, 9, 11],
                "orderable": false,
            }],
        });



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
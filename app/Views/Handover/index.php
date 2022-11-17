<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Handover</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="card">
    <div class="card-header bg-green">
        <button class="btn btn-sm btn-info" type="button" onclick="location.href=('<?= site_url('/Handover/buatManifest') ?>')">
            <i class="fa fa-plus"></i>
            Tambah Data</button>
    </div>
    <div class="card-body">

        <table id="example1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>warehouse</th>
                    <th>ID Handover</th>
                    <th>List Order</th>
                    <th>Driver</th>
                    <th>Foto</th>
                    <th>Tanda Tangan</th>
                    <th>Status</th>
                </tr>
            </thead>

        </table>
    </div>
</div>
<!-- <div class=" card">
            <div class="card-header bg-white">

            </div>
            <div class="card-body">
                <div class="row" id="tampilDataManifest">
                </div>
            </div>
    </div> -->
<div class="manifest" style="display: none;"></div>

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "info": true,
            "ajax": {
                "url": "<?php echo site_url('Handover/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
            dom: 'lBftip', // Add the Copy, Print and export to CSV, Excel and PDF buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false,
            }],
        });
    });

    function play_notif() {
        var audio = document.createElement('audio');
        audio.setAttribute('src', '<?= site_url() ?>/dist/img/success.mp3');
        audio.setAttribute('autoplay', 'autoplay');
        audio.play();
        audio.load();
    }

    function kosong() {
        $('#orderId').val('');
        $('#orderId').focus();
    }


    $(document).ready(function() {
        $('#table1').DataTable();
        kosong();
        $('#tombolcariIn').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url() ?>/Handover/buatManifest",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.manifest').html(response.data).show();
                        $('#manifest').modal('show');
                        kosong();

                    }
                }
            });
        });

    });
</script>
<?= $this->endsection('isi'); ?>
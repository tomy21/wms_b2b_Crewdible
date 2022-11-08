<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Report Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        Export Report Outbound
                    </div>
                    <div class="card-body">
                        <?= form_open(site_url('Main/downloadOutbound')) ?>
                        <div class="form-group">
                            <label>Tanggal Mulai :</label>
                            <div class="input-group date" id="awal" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#awal" name="valAwalOut" />
                                <div class="input-group-append" data-target="#awal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Akhir:</label>
                            <div class="input-group date" id="akhir" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#akhir" name="valAkhirOut" />
                                <div class="input-group-append" data-target="#akhir" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" id="btnOutbound"><i class="fa fa-download"></i> download data</button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        Export Report Inbound
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tanggal Mulai :</label>
                            <div class="input-group date" id="awalIn" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#awalIn" id="valAwalIn" />
                                <div class="input-group-append" data-target="#awalIn" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Akhir:</label>
                            <div class="input-group date" id="akhirIn" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#akhirIn" id="valAkhirIn" />
                                <div class="input-group-append" data-target="#akhirIn" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" id="btnInbound"><i class="fa fa-download"></i> download data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabel1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#report1 .col-md-6:eq(0)');
    });
    $(document).ready(function() {
        $('#awal').datetimepicker({
            format: 'L'
        });
        $('#akhir').datetimepicker({
            format: 'L'
        });
        $('#awalIn').datetimepicker({
            format: 'L'
        });
        $('#akhirIn').datetimepicker({
            format: 'L'
        });

        // $('#btnOutbound').click(function(e) {
        //     e.preventDefault();
        //     let awalOut = $('#valAwalOut').val();
        //     let akhirOut = $('#valAkhirOut').val();

        //     $.ajax({
        //         type: "POST",
        //         url: "<?= site_url('Main/downloadOutbound') ?>",
        //         data: {
        //             dateAwal:awalOut,
        //             dateAkhir: akhirOut,
        //         },
        //         dataType: "JSON",
        //         success: function (response) {

        //         }
        //     });

        // });
    });
</script>
<?= $this->endsection('isi'); ?>
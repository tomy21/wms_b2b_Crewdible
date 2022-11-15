<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1> Inbound </h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>
<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h5>Inbound Received</h5>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-striped" style="width: 100%;">
                <thead>
                    <th>No</th>
                    <th>Created date</th>
                    <th>No_Po</th>
                    <th>Warehouse</th>
                    <th>Driver</th>
                    <th>Foto Barang</th>
                    <th>Foto Surat Jalan</th>
                    <th>Jumlah Order</th>
                    <th>Quantity Order</th>
                    <th>Quantity Counting</th>
                    <th>Selisih</th>
                    <th>Selesai Inbound</th>
                    <th>#</th>
                    <?php if (user()->warehouse == 'Headoffice') :  ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </thead>
            </table>

        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
    function edit(nopo) {
        window.location.href = ("<?= site_url('/inbound/edit/') ?>") + nopo;
    }

    function detail(nopo) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/inbound/detail') ?>",
            data: {
                [crsfToken]: crsfHash,
                nopo: nopo,
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalitem').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function hapus(nopo) {
        Swal.fire({
            title: 'Hapus PO ini',
            text: "Yakin akan dihapus ? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Sekarang !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Inbound/hapusData') ?>",
                    data: {
                        nopo: nopo,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            window.location.reload();
                        }
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "info": true,
            "ajax": {
                "url": "<?php echo site_url('Inbound/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
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
</script>
<?= $this->endsection('isi'); ?>
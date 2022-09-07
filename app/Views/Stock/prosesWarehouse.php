<?= $this->extend('layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Picklist Assignment</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<!-- Datatable checkbox -->
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css"
    rel="stylesheet" />
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>


<!-- Main row -->
<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-white">
            <h3 class="card-title">List Order</h3>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <?= form_open('picking/updateAssign', ['class' => 'formUpdateBatch']) ?>
                    <p>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlSelect1">Nama Picker</label>
                        <select class="form-control" name="user" id="user" required>
                            <option value="" selected disabled hidden>Choose here</option>
                            <?php foreach ($dataKar->getResultArray() as $row) : ?>
                            <option value="<?= $row['nama_id'] ?>"><?= $row['nama_id'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-info" type="submit">
                        <i class="fa fa-plus"> Assign</i>
                    </button>
                    <button class="btn btn-sm btn-success" id="spk">
                        <i class="fa fa-save"> Kirim SPK</i>
                    </button>
                    </p>
                    <p>
                        <span class="badge badge-dark">Transaksi Baru</span>
                        <span class="badge badge-info">Assign</span>
                        <span class="badge badge-primary">Picking</span>
                        <span class="badge badge-secondary">Sorting</span>
                        <span class="badge badge-warning">Packing</span>
                        <span class="badge badge-Fuchsia">Shipping</span>
                        <span class="badge badge-success">Done</span>
                        <span class="badge badge-danger">Return</span>
                    </p>
                    <table id="viewStatus" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>
                                <input type="checkbox" id="centangsemua">
                            </th>
                            <th>Order Id</th>
                            <th>Item ID</th>
                            <th>Item Detail</th>
                            <th>Assign</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                foreach ($data as $row) :
                                ?>
                                <td>
                                    <input type="checkbox" name="id[]" class="centangId" value="<?= $row['id']; ?>">
                                </td>
                                <td><?= $row['Order_id']; ?></td>
                                <input type="hidden" name="order[]" value="<?= $row['Order_id']; ?>">
                                <td><?= $row['Item_id']; ?></td>
                                <td><?= $row['Item_detail']; ?></td>
                                <td><?= $row['assign']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td>
                                    <?php if ($user->status == "1") : ?>
                                    <span class="badge badge-dark">Transaksi Baru</span>
                                    <?php elseif ($user->status == "2") :  ?>
                                    <span class="badge badge-info">Assign</span>
                                    <?php elseif ($user->status == "3") :  ?>
                                    <span class="badge badge-primary">Picking</span>
                                    <?php elseif ($user->status == "4") :  ?>
                                    <span class="badge badge-secondary">Sorting</span>
                                    <?php elseif ($user->status == "5") :  ?>
                                    <span class="badge badge-warning">Packing</span>
                                    <?php elseif ($user->status == "6") :  ?>
                                    <span class="badge badge-Fuchsia">Shipping</span>
                                    <?php elseif ($user->status == "7") :  ?>
                                    <span class="badge badge-success">Done</span>
                                    <?php elseif ($user->status == "8") :  ?>
                                    <span class="badge badge-danger">Return</span>
                                    <?php endif; ?>
                                </td>


                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modalCari" style="display: none;"></div>
</div>
<script>
$('#spk').click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Submit Picking',
        text: "Yakin Akan Submit ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Submit Sekarang !'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/picking/spk",
                dataType: "json",
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
                        play_notif();

                    }

                }
            });
        }
    })
});
$(document).ready(function() {
    $('#viewStatus').DataTable();

    $('#centangsemua').click(function(e) {
        if ($(this).is(':checked')) {
            $('.centangId').prop('checked', true);
        } else {
            $('.centangId').prop('checked', false);
        }
    });
    $('.formUpdateBatch').submit(function(e) {
        e.preventDefault();
        let jlmhData = $('.centangId:checked');
        let user = $('#user').val();

        if (jlmhData.length === 0) {
            Swal.fire({
                icon: 'error',
                tittle: 'Warning',
                text: 'Pilih Data dulu'
            })
        } else if (user.length == 0) {
            Swal.fire({
                icon: 'error',
                tittle: 'Warning',
                text: 'Pilih Picker Dulu'
            })
        } else {
            Swal.fire({
                title: 'Apakah sudah selesai ?',
                text: `Update ${jlmhData.length} Sekarang`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Simpan !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    icon: 'success',
                                    text: response.sukses
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                        play_notif();
                                    }
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }
            })
        }
    });
    $('#assign').click(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Apakah sudah selesai ?',
            text: "Yakin sudah mau Assign",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Simpan !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/picking/simpanData",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                title: 'Error',
                                icon: 'warning',
                                text: response.error
                            });
                        }
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Berhasil',
                                icon: 'success',
                                text: response.sukses
                            });
                            window.location.reload();
                            play_notif();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endsection('isi'); ?>
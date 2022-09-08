<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Order Status</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12"></div>
<div class="card">

    <div class="card-header bg-danger">
        <h4>Table Assign Picker</h4>
    </div>
    <div class="card-body">
        <?= form_open('Picking/ProsesPick', ['class' => 'formAssignPicker']) ?>
        <p class="float-right">
            <button class="btn btn-secondary" id="btnRefresh"><i class="fa fa-sync-alt"></i>&nbsp;
                Refresh</button>&nbsp;
            <button type="submit" class="btn btn-info"><i class="fa fa-file-upload"></i>&nbsp; Proses
                Picking</button>
        </p>
        <p>
        <div class="form-group col-sm-3">
            <label for="exampleFormControlSelect1">Nama Picker</label>
            <select class="form-control" name="user" id="user">
                <option>- Pilih -</option>
                <?php foreach ($dataKar->getResultArray() as $row) : ?>
                <option value="<?= $row['nama_id'] ?>"><?= $row['nama_id'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        </p>
        <br>
        <table id="viewStatus" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="centangsemua">
                    </th>
                    <th>No</th>
                    <th>Item id</th>
                    <th>Item Detail</th>
                    <th>Quantity</th>
                </tr>

            </thead>
            <tbody>
                <?php

                $no = 1;
                foreach ($data as $query) :
                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="id[]" class="centangId" value="<?= $query['Item_id'] ?>">
                    </td>
                    <input type="hidden" name="id[]" class="centangId" value="<?= $query['Item_id'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= $query['Item_id'] ?></td>
                    <td>
                        <?= $query['Item_detail'] ?>
                    </td>
                    <td>
                        <?= $query['qty'] ?>
                    </td>
                </tr>
                <input type="hidden" name="item[]" value="<?= $query['Item_id'] ?>">
                <input type="hidden" name="detail[]" value="<?= $query['Item_detail'] ?>">
                <input type="hidden" name="jumlah[]" value="<?= $query['qty'] ?>">
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= form_close(); ?>
    </div>
</div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
$('#btnRefresh').click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Refresh Order',
        text: "Yakin Akan Refresh ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Refresh Sekarang !'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/picking/refresh",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
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
});

function play_notif() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= base_url() ?>/dist/img/success.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

function play_notifSalah() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= base_url() ?>/dist/img/Salah2.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

$(document).ready(function() {
    $('#centangsemua').click(function(e) {
        if ($(this).is(':checked')) {
            $('.centangId').prop('checked', true);
        } else {
            $('.centangId').prop('checked', false);
        }
    });

    $('.formAssignPicker').submit(function(e) {
        e.preventDefault();
        let jlmhData = $('.centangId:checked');

        if (jlmhData.length === 0) {
            Swal.fire({
                icon: 'error',
                tittle: 'Warning',
                text: 'Pilih Data dulu'
            })
        } else {
            Swal.fire({
                title: 'Assign Picking',
                text: `Update ${jlmhData.length} Sekarang`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Receive Sekarang !'
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
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Berhasil',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                window.location.reload();
                                play_notif();
                            }
                            if (response.input) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.input,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = (
                                            '/Inbound/index')
                                    }
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }
            });
        }


    });
});
</script>

<?= $this->endsection('isi'); ?>
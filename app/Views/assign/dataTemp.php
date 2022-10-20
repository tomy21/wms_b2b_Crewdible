<div class="card">

    <div class="card-header bg-green">
        List Transaksi
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-12">
                <button class="btn btn-info float-right" style="margin-bottom: 20px;" id="assign">Assign
                    Sekarang</button>
            </div>
        </div>

        <div class="row">
            <div class="form-hroup col-md-12">
                <table id="table1" class="table table-sm table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <th style="width: 5%;">No</th>
                        <th>id_basket</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Assign</th>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($datatemp as $row) :
                        ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $row['id_basket']; ?></td>
                            <td><?= $row['Item_id']; ?></td>
                            <td><?= $row['Item_detail']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= $row['nama_user']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$('#assign').click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Assign Picking',
        text: "Yakin Submit sekarang ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proses Sekarang !'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url() ?>/Assign/assign",
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil',
                        });
                        window.location.reload();
                        play_notif();
                    }
                    if (response.error) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.error,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
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

$(document).ready(function() {
    $('#table1').DataTable();
});
</script>
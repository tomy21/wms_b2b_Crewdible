<div class="modal fade" id="modalbarang" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cari Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?= form_open('Assign/ProsesPick', ['class' => 'formAssignPicker']) ?>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input type="hidden" name="warehouse" value="<?= user()->warehouse ?>">
                        <label for="">Basket</label>
                        <div class="input-group col-mb-4">
                            <select name="basket" id="basket" class="form-control" required>
                                <option value="" selected disabled> -- pilih basket -- </option>
                                <?php
                                $db = \Config\Database::connect();
                                if (user()->warehouse == 'Headoffice') {
                                    $basket = $db->table('tbl_masterbasket')->get()->getResult();
                                } else {
                                    $basket = $db->table('tbl_masterbasket')->getWhere(['warehouse' => user()->warehouse, 'status' => 0])->getResult();
                                }

                                foreach ($basket as $row) :
                                ?>
                                <option value="<?= $row->id_basket ?>"><?= $row->id_basket ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="">Picker</label>
                        <div class="input-group col-mb-4">
                            <select name="picker" id="picker" class="form-control" required>
                                <option value="" selected disabled> -- pilih picker -- </option>
                                <?php
                                $db = \Config\Database::connect();
                                $basket = $db->table('tbl_karyawan')->getWhere(['warehouse' => user()->warehouse, 'level' => 'picker'])->getResult();
                                foreach ($basket as $row) :
                                ?>
                                <option value="<?= $row->id_user ?>"><?= $row->nama_user ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>


                <p>
                    <button type="submit" class="btn btn-success">Submit</button>
                </p>
                <table id="view" class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="centangsemua"></th>
                            <th>Warehouse</th>
                            <th>Code Barang</th>
                            <th>Nama Barang</th>
                            <th>Slot</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $db = \Config\Database::connect();
                        if (user()->warehouse == 'Headoffice') {
                            $listBarang = $db->table('tbl_invoice')->where(['status' => 1])->select('id, Item_id,Item_detail, sum(quantity) as quantity,stock_location,slot')->groupBy('Item_id,Item_detail,stock_location,slot')->get()->getResult();
                        } else {
                            $listBarang = $db->table('tbl_invoice')->where(['stock_location' => user()->warehouse, 'status' => 1])->select('id, Item_id,Item_detail, sum(quantity) as quantity,stock_location,created_at,slot')->groupBy('Item_id,Item_detail,stock_location')->get()->getResult();
                        }
                        foreach ($listBarang as $row) :
                        ?>
                        <tr>
                            <td>

                                <input type="checkbox" name="id[]" class="centangId" value="<?= $row->Item_id ?>">

                            </td>
                            <td><?= $row->stock_location ?></td>
                            <td><?= $row->Item_id; ?></td>
                            <td><?= $row->Item_detail; ?></td>
                            <td>Slot <?= $row->slot ?></td>
                            <td><?= $row->quantity; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
function cariSKUbarang() {
    let cari = $('#cari').val();
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>/Picking/CariDetailBarang",
        data: {
            cari: cari
        },
        dataType: "json",
        beforeSend: function(response) {
            $('.listbarang').html('<i class="fa fa-spin fa-spinner"</i>')
        },
        success: function(response) {
            if (response.data) {
                $('.listbarang').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
$(document).ready(function() {
    $('#btnCariBarang').click(function(e) {
        e.preventDefault();
        cariSKUbarang();

    });
    $('#cari').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cariSKUbarang();
        }
    });
    $('#view').DataTable();
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
                text: `Assign ${jlmhData.length} Sekarang`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Assign Sekarang !'
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
<div class="modal fade" id="modalInbound" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-green">
                <h5 class="modal-title">Validation Inbound</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(site_url('Inbound/simpanInbound'), ['class' => 'formInputInbound'])  ?>
            <div class="modal-body">
                <div class="form-group col-md-6">
                    <label for="">No Po</label>
                    <input type="text" class="form-control" name="nopo" id="nopo" value="<?= $nopo ?>" readonly>
                </div>
                <table>
                    <table class="table table-sm table-striped table-bordered" style="width: 100%;">
                        <thead>

                            <th style="width: 5%;">No</th>
                            <th>Item Id</th>
                            <th>Item Detail</th>
                            <th>Qty kirim</th>
                            <th>Qty Good</th>
                            <th>Qty Bad</th>
                            <th>Selisih</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($dataInbound as $row) :
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['Item_id']; ?></td>
                                <td><?= $row['Item_detail']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td><?= $row['stock_good']; ?></td>
                                <td><?= $row['stock_bad']; ?></td>
                                <td>
                                    <?php
                                        if (intval($row['quantity']) < (intval($row['stock_good']) + intval($row['stock_bad']))) :
                                            $stock = (intval($row['stock_good']) + intval($row['stock_bad'])) - intval($row['quantity']);
                                        ?>
                                    <span class="badge badge-danger">
                                        <?= "Barang Lebih $stock" ?>
                                    </span>
                                    <?php
                                        elseif (intval($row['quantity']) > (intval($row['stock_good']) + intval($row['stock_bad']))) :
                                            $stock = intval($row['quantity']) - (intval($row['stock_good']) + intval($row['stock_bad']));
                                        ?>
                                    <span class="badge badge-warning">
                                        <?= "Barang Kurang $stock" ?>
                                    </span>
                                    <?php
                                        elseif (intval($row['quantity']) == (intval($row['stock_good']) + intval($row['stock_bad']))) :
                                            $stock = intval($row['quantity']) - (intval($row['stock_good']) + intval($row['stock_bad']));
                                        ?>
                                    <span class="badge badge-success">
                                        <?= "Tidak Ada Selisih" ?>
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <input type="text" name="reason[]"
                                        value="<?php $stock = intval($row['quantity']) - (intval($row['stock_good']) + intval($row['stock_bad'])); ?>">
                                </td>
                            </tr>
                            <input type="hidden" name="itemid[]" value="<?= $row['Item_id']; ?>">
                            <input type="hidden" name="itemdetail[]" value="<?= $row['Item_detail']; ?>">
                            <input type="hidden" name="qtyKirim[]" value="<?= $row['quantity']; ?>">
                            <input type="hidden" name="qtyGood[]" value="<?= $row['stock_good']; ?>">
                            <input type="hidden" name="qtyBad[]" value="<?= $row['stock_bad']; ?>">
                            <input type="hidden" name="selisih[]" value="<?= $stock; ?>">
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            <?php form_close(); ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.formInputInbound').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Receive Item',
            text: "Yakin Akan Submit ? ",
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
                        if (response.update) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.update,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = (
                                        '<?= site_url('/Inbound/index') ?>'
                                    )
                                }
                            })
                        }
                        if (response.input) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.input,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = (
                                        '<?= site_url('/Inbound/index') ?>'
                                    )
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
    });
});
</script>
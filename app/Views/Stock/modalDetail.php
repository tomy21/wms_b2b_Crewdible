<div class="modal fade" id="modalitem" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header bg-success">
                        Receive Barang
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">

                                <input type="text" class="form-control" name="Nopes[]" id="Nopes"
                                    value="<?= $NoOrder ?>" readonly
                                    style="border: none; background:none; font-size:larger;">
                                </h1>
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control select2" name="assign[]" id="assign">
                                    <option>- Pilih Picker -</option>
                                    <option value="User1">User 1</option>
                                    <option value="User2">User 2</option>
                                    <option value="User3">User 3</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="button" class="btn btn-sm btn-success form-control" id="btnIn">
                                    Pick</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="viewStatus" class="table table-striped" style="width: 100%;">
                    <thead>

                        <th>No</th>
                        <th>Order Id</th>
                        <th>Item Id</th>
                        <th>Item Detail</th>
                        <th>Quantity</th>
                    </thead>

                    <tbody>
                        <tr>
                            <?php
                            $no = 1;
                            foreach ($detailin->getResultArray() as $row) :
                            ?>
                            <td><?= $no++ ?></td>
                            <td><?= $row['Order_id'] ?></td>
                            <td><?= $row['Item_id'] ?></td>
                            <td><?= $row['Item_detail'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('.select2').select2()
});

$('#btnIn').click(function(e) {
    e.preventDefault();
    let assign = $('#assign').val();
    let Nopes = $('#Nopes').val();
    $.ajax({
        type: "post",
        url: "/ProsesInvoice/savePick",
        data: {
            assign: assign,
            Nopes: Nopes
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    icon: 'success',
                    title: 'Assignment Sudah di Proses',
                    text: response.sukses,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                })
            }
        }
    });
});
</script>
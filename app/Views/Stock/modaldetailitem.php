<div class="modal fade" id="modalitem" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-border table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Item Id</td>
                            <td>Item Detail</td>
                            <td>Quantity</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($tampildatadetail->getResultArray() as $row) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['Item_id']; ?></td>
                            <td><?= $row['Item_detail']; ?></td>
                            <td><?= $row['quantity']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
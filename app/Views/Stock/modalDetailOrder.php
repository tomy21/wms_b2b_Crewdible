<div class="modal fade" id="modalitem" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="viewStatus" class="table table-striped" style="width: 100%;">
                    <thead>
                        <th>No</th>
                        <th>Item Id</th>
                        <th>Item Detail</th>
                        <th>Quantity</th>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $no = 1;
                            foreach ($isidata->getResultArray() as $row) :
                            ?>
                            <td>1</td>
                            <td>2</td>
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
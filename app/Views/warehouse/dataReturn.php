<div class="col-lg-12">
    <div class="card">

        <div class="card-body">
            <p class="col-md-2">
                <input type="text" class="form-control" style="background-color: none ; border:none;" id="OrderId"
                    name="OrderId" value="<?= $OrderId; ?>" readonly>
            </p>
            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Id</th>
                        <th>Item Detail</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($tampilData->getResultArray() as $row) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
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
<script>

</script>
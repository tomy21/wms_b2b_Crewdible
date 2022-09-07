<div class="col-md-12">
    <table id="viewStatus" class="table table-striped" style="width: 100%;">
        <thead>
            <th>No</th>
            <th>Item Id</th>
            <th>Item Detail</th>
            <th>Quantity</th>
            <th>Assign</th>
        </thead>
        <tbody>
            <?php
            $nomor = 1;
            foreach ($datatemp->getResultArray() as $row) :
            ?>
                <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $row['Item_id']; ?></td>
                    <td><?= $row['Item_detail']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td><?= $row['assign']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<script>
    $(document).ready(function () {
        $('#viewStatus').DataTable();
    });
</script>
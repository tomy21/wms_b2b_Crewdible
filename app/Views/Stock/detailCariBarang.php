<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Code SKU</th>
            <th>Nama SKU</th>
            <th>Qty</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['Item_id']; ?></td>
            <td><?= $row['Item_detail']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td>
                <button class="btn btn-sm btn-success" type="button" onclick="add(<?= $row['Item_id']; ?>)">Add</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function add(itemId) {
    $('#inputsku').val(itemId);
    $('#modalcaribarang').on('hidden.bs.modal', function(event) {
        ambilDataSKU();
    })
    $('#modalcaribarang').modal('hide');
}
</script>
<p>
    <button type="button" class="btn btn-success" id="btnSubmit">Submit</button>
</p>
<table id="view" class="table table-sm table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Order Id</th>
            <th>Driver</th>
            <th>Nama Penerima</th>
            <th>Alamat</th>
            <th>No Telepon</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($query as $y) :
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $y->order_id ?></td>
            <td><?= $y->driver ?></td>
            <td><?= $y->nama_penerima ?></td>
            <td><?= $y->alamat ?></td>
            <td><?= $y->no_tlp ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#viewStatus').DataTable();
});
</script>
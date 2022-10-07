<div class="card">

    <div class="card-header bg-green">
        List Transaksi
    </div>
    <div class="card-body">

        <table id="table1" class="table table-sm table-striped table-bordered" style="width: 100%;">
            <thead>
                <th style="width: 5%;">No</th>
                <th>Order Id</th>
                <th>Item Id</th>
                <th>Item Detail</th>
                <th>Total Item</th>
                <th>Total Picking</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                foreach ($datatemp as $row) :
                ?>
                <tr>
                    <td style="vertical-align: middle;"><?= $nomor++; ?></td>
                    <td style="vertical-align: middle;"><?= $row->Order_id; ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();
                            foreach ($jumlah as $data) :
                            ?>
                        <ol><?= $data->Item_id ?></ol>
                        <?php endforeach; ?>
                    </td>
                    <td style="vertical-align: middle;">
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();
                            foreach ($jumlah as $data) :
                            ?>
                        <ol><?= $data->Item_detail ?></ol>
                        <?php endforeach; ?>
                    </td>
                    <td style="vertical-align: middle;">
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();
                            foreach ($jumlah as $data) :
                            ?>
                        <ol><?= $data->quantity ?></ol>
                        <?php endforeach; ?>
                    </td>
                    <td style=" vertical-align: middle; text-align: center;"><?= $row->jumlah ?></td>
                    <td style="vertical-align: middle; text-align: center;">
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();

                            $total = 0;
                            foreach ($jumlah as $data) {
                                $total += $data->quantity;
                            }
                            if ($total != $row->jumlah) :
                            ?>
                        <span class="badge badge-info">On Proses</span>
                        <?php elseif ($total == $row->jumlah) : ?>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="edit('<?= $row->Order_id; ?>')"><i class="fa fa-print"></i>
                        </button>
                        <?php elseif ($row->status == 5) : ?>
                        <span class="badge badge-success">Done</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#table1').DataTable();
});

function edit(nopo) {
    window.open(("<?= site_url('Sorting/invoice/') ?>") + nopo, '_blank');
    window.location.reload();
}
</script>
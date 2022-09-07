<link rel="stylesheet" href="<?= base_url() ?>/dist/css/jquery.nice-number.css">

<input type="hidden" id="nopo" value="<?= $nopo ?>">
<?php form_open(site_url('Inbound/simpanInbound'), ['class' => 'formdatabanyak']) ?>
<p>
    <button type="submit" class="btn btn-sm btn-info"> Simpan </button>
</p>
<table class="table table-sm table-striped table-bordered" style="width: 100%;">
    <thead>
        <th>
            <input type="checkbox" id="centangsemua">
        </th>
        <th style="width: 5%;">No</th>
        <th>Item Id</th>
        <th>Item Detail</th>
        <th>Qty kirim</th>
        <th>Qty Good</th>
        <th>Qty Bad</th>
    </thead>
    <tbody>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($datatemp->getResultArray() as $row) :
        ?>
        <tr>
            <td>
                <input type="checkbox" name="id[]" class="centangId" value="<?= $row['id']; ?>">
            </td>
            <td><?= $nomor++; ?></td>
            <td><?= $row['Item_id']; ?></td>
            <td><?= $row['Item_detail']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td>
                <input type="number" name="good[]" id="good" value="0" min="0" max="1000" />
            </td>
            <td>
                <input type="number" name="bad[]" id="bad" value="0" min="0" max="1000" />
            </td>

        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php form_close(); ?>
    </tbody>
</table>
<script src="<?= base_url() ?>/dist/js/jquery.nice-number.js"></script>
<script>
$(document).ready(function() {
    $('.formdatabanyak').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        title: 'Berhasil',
                        icon: 'success',
                        text: response.sukses
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back();
                            play_notif();
                        }
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
});

$('input[type="number"]').niceNumber({

    // auto resize the number input
    autoSize: true,

    // the number of extra character
    autoSizeBuffer: 1,

    // custom button text
    buttonDecrement: '-',
    buttonIncrement: "+",

    // 'around', 'left', or 'right'
    buttonPosition: 'around',
    onDecrement: false,
    onIncrement: false,

});
</script>
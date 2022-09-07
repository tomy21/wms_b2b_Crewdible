<div class="modal fade" id="modalcaribarang" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cari Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Code atau Nama SKU" id="cari">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" id="btnCariSKU">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="row viewtampildata"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
function cariDataBarang() {
    let cari = $('#cari').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "/inbound/detailCariBarang",
        data: {
            [crsfToken]: crsfHash,
            cari: cari
        },
        dataType: "json",
        beforeSend: function() {
            $('.viewtampildata').html('<i class="fa fa-spin fa-spinner"</i>')
        },
        success: function(response) {
            if (response.data) {
                $('.viewtampildata').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }

    });
}
$(document).ready(function() {
    $('#btnCariSKU').click(function(e) {
        e.preventDefault();
        cariDataBarang();
    });
    $('#cari').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cariDataBarang();
        }
    });
});
</script>
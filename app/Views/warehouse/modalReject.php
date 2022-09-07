<div class="modal fade" id="modalitem" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Item Return Reject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="OrderId">Order Id</label>
                        <input type="text" class="form-control" id="OrderId" value="<?= $OrderID ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ItemId">Item Id</label>
                        <input type="text" class="form-control" id="ItemId" value="<?= $ItemId ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Itemdetail">Item Detail</label>
                        <input type="text" class="form-control" id="Itemdetail" value="<?= $ItemDetail ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="text" class="form-control" id="qty" value="<?= $quantity ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="receive">Receive by</label>
                        <input type="text" class="form-control" id="receive" value="<?= session()->get('namaUser') ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <textarea name="reason" id="reason" class="form-control" rows="0" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success" id="input">Input Return</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function play_notif() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= base_url() ?>/dist/img/success.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

function play_notifSalah() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= base_url() ?>/dist/img/Salah2.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

$('#input').click(function(e) {

    e.preventDefault();
    let ItemId = $('#ItemId').val();
    let ItemDetail = $('#Itemdetail').val();
    let reason = $('#reason').val();
    let qty = $('#qty').val();
    let OrderId = $('#OrderId').val();
    let receive = $('#receive').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';

    $.ajax({
        type: "post",
        url: "/ReturnItem/inputDataRtn",
        data: {
            ItemId: ItemId,
            ItemDetail: ItemDetail,
            qty: qty,
            reason: reason,
            receive: receive,
            OrderId: OrderId,
            [crsfToken]: crsfHash,
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Berhasil'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = ('/ReturnItem/index/');
                    }
                });
                play_notif();
                $('#modalitem').modal('hide');
            }
        }
    });
});
$(document).ready(function() {

});
</script>
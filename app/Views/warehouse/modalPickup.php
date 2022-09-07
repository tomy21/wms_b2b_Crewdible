<div class="modal fade" id="modalitem" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Item Return</h5>
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
                        <label for="ItemId">Item Detail</label>
                        <input type="text" class="form-control" id="Itemdetail" value="<?= $ItemDetail ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ItemId">Quantity</label>
                        <input type="text" class="form-control" id="qty" value="<?= $quantity ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ItemId">Receive by</label>
                        <input type="text" class="form-control" id="received" value="<?= session()->get('namaUser') ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="ItemId">Reason</label>
                        <input type="text" name="reason" id="reason" class="form-control" rows="0" required></input>
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
    let OrderId = $('#OrderId').val();
    let ItemId = $('#ItemId').val();
    let ItemDetail = $('#ItemDetail').val();
    let reason = $('#reason').val();
    let qty = $('#qty').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';

    $.ajax({
        type: "post",
        url: "/ReturnItem/inputData",
        data: {
            ItemId: ItemId,
            ItemDetail: ItemDetail,
            qty: qty,
            OrderId: OrderId,
            reason: reason,
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
<div class="modal fade" id="modaledit" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $Order_id ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open(site_url('Handover/UpdateDate'), ['class' => 'formUpdateDate']) ?>
                <input type="hidden" name="orderId" value="<?= $Order_id ?>">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="date" class="form-control" value="<?= $updated_at ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-success form-control btnSimpan"><i class="fa fa-save"></i></button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formUpdateDate').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $('.btnSimpan').prop('disable', true);
                    $('.btnSimpan').html('<i class="fa fa-spinner></i>');
                },
                complete: function() {
                    $('.btnSimpan').prop('disable', false);
                    $('.btnSimpan').html('Simpan');
                },
                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                        play_notif();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

        });
    });
</script>
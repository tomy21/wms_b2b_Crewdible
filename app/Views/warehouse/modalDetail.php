<link rel="stylesheet" href="<?= site_url() ?>/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= site_url() ?>/dist/css/adminlte.min.css">

<div class="modal fade" id="modalDetail" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $nopo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none"><?= $nopo ?></h3>
                        <div class="col-12">
                            <img src="<?= site_url() ?>/assets/inbound/<?= $fotobarang ?>" class="product-image"
                                alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs" style="height: 60%; width: 100% ;">
                            <div class="product-image-thumb active" style="height: 60%; width: 100% ;"><img
                                    src="<?= site_url() ?>/assets/inbound/<?= $fotobarang ?>" alt="Product Image"></div>
                            <div class="product-image-thumb active" style="height: 60%; width: 100% ;"><img
                                    src="<?= site_url() ?>/assets/inbound/<?= $fotosjl ?>" alt="Product Image"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><?= $nopo ?></h3>

                        <hr>
                        <h4>Nama Driver</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <h4><?= $driver ?></h4>
                        </div>
                        <hr>

                        <h5 class="mt-3">No Plat Kendaraan</h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <h4><?= $plat ?></h4>
                        </div>
                        <hr>

                        <h5>Tanggal Kedatangan</h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <h4><?= $datang ?></h4>
                        </div>
                        <hr>

                        <h5>Tanggal Bongkar</h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <h4><?= $diterima ?></h4>
                        </div>
                        <hr>

                        <h5>Tanggal Input Stock</h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <h4><?= $selving ?></h4>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?= site_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= site_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= site_url() ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= site_url() ?>/dist/js/demo.js"></script>
<script>
$(document).ready(function() {
    $('.product-image-thumb').on('click', function() {
        var $image_element = $(this).find('img')
        $('.product-image').prop('src', $image_element.attr('src'))
        $('.product-image-thumb.active').removeClass('active')
        $(this).addClass('active')
    })
})
</script>
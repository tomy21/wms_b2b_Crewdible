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
                <!-- <h3><?= $nopo ?></h3>
                <hr>
                <h5 class="d-flex justify-content-start"><?= $driver ?></h5>
                <h5 class="d-flex justify-content-start"><?= $plat ?></h5>
                <img src="<?= site_url() ?>/assets/inbound/<?= $fotobarang ?>" alt="">
                <img src="<?= site_url() ?>/assets/inbound/<?= $fotosjl ?>" alt="">
                </h6> -->
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none"><?= $nopo ?></h3>
                        <div class="col-12">
                            <img src="<?= site_url() ?>/assets/inbound/<?= $fotobarang ?>" class="product-image"
                                alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <div class="product-image-thumb active"><img
                                    src="<?= site_url() ?>/assets/inbound/<?= $fotosjl ?>" alt="Product Image"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><?= $nopo ?></h3>

                        <hr>
                        <h4>Nama Driver</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?= $driver ?>
                        </div>
                        <hr>

                        <h4 class="mt-3">No Plat Kendaraan</small></h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?= $plat ?>
                        </div>

                        <h4>Tanggal Kedatangan</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?= $datang ?>
                        </div>
                        <hr>
                        <h4>Tanggal Bongkar</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?= $diterima ?>
                        </div>
                        <hr>
                        <h4>Tanggal Inputr Stock</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?= $selving ?>
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
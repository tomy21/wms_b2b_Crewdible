<link rel="stylesheet" href="<?= site_url() ?>/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= site_url() ?>/dist/css/adminlte.min.css">

<div class="modal fade" id="modalDetail" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $Order_id ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none"><?= $Order_id ?></h3>
                        <div class="col-12">
                            <img src=" https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/<?= $foto_before ?>"
                                class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <div class=" product-image-thumb active"><img
                                    src="https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/<?= $foto_before ?>"
                                    alt="Product Image">
                            </div>
                            <div class="product-image-thumb active"><img
                                    src="https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/<?= $foto_after ?>"
                                    alt="Product Image">
                            </div>
                            <div class="product-image-thumb active"><img
                                    src="https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/<?= $foto_handover ?>"
                                    alt="Product Image">
                            </div>
                            <div class="product-image-thumb active"><img
                                    src="https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/<?= $tandatangan ?>"
                                    alt="Product Image">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><?= $Order_id ?></h3>

                        <hr>
                        <h4>Nama Driver</h4>
                        <div class="btn-group btn-group-toggle">
                            <h4><?= $driver ?></h4>
                        </div>
                        <hr>

                        <h5 class="mt-3">Date Slot</h5>
                        <div class="btn-group btn-group-toggle">
                            <h4><?= $time_slot ?></h4>
                        </div>
                        <hr>

                        <h5>Selesai Packing</h5>
                        <div class="btn-group btn-group-toggle">
                            <h4><?= $time_packing ?></h4>
                        </div>
                        <hr>

                        <h5>Penerima</h5>
                        <div class="btn-group btn-group-toggle">
                            <h4><?= $penerima ?></h4>
                        </div>
                        <hr>

                        <h5>Alamat</h5>
                        <div class="btn-group btn-group-toggle">
                            <h4><?= $alamat ?></h4>
                        </div>
                        <hr>
                        <h5>No Telepone</h5>
                        <div class="btn-group btn-group-toggle">
                            <h4><?= $no_tlp ?></h4>
                        </div>
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
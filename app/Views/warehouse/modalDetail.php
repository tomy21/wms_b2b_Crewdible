<div class="modal fade" id="modalDetail" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $nopo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3><?= $nopo ?></h3>
                <hr>
                <h5 class="d-flex justify-content-start"><?= $driver ?></h5>
                <h5 class="d-flex justify-content-start"><?= $plat ?></h5>
                <img src="<?= site_url() ?>/assets/inbound/<?= $fotobarang ?>" alt="">
                <img src="<?= site_url() ?>/assets/inbound/<?= $fotosjl ?>" alt="">
                </h6>
            </div>
        </div>
    </div>
</div>
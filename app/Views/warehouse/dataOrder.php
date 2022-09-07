<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <div class="form-group col-md-2">
                <label for="">No Orderan</label>
                <input type="text" class="form-control" id="qtyIn" name="qtyIn" value="<?= $order; ?>" readonly>
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="">Item Id</label>
                                <input type="text" class="form-control" placeholder="Masukn Kode Item" id="item_id"
                                    name="item_id" value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Nama Barang</label>
                                <input type="text" class="form-control" placeholder="Nama SKU" id="item_detail"
                                    name="item_detail" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Qty Stock</label>
                                <input type="number" class="form-control" id="qty" name="qty" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Qty Picking</label>
                                <input type="number" class="form-control" id="qtyIn" name="qtyIn">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Aksi</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-info" title="Tambah Item" id="tambahItem"> <i
                                            class="fa fa-plus"></i> </button>&nbsp;
                                    <button type="button" class="btn btn-success" title="Proses Item" id="tambahItem">
                                        <i class="fa fa-upload"></i> </button>
                                </div>
                            </div>
                        </div>
                        <table id="viewStatus" class="table table-striped" style="width: 100%;">
                            <thead>

                                <th>No</th>
                                <th>Item Id</th>
                                <th>Item Detail</th>
                                <th>Quantity</th>
                                <th>Assign</th>
                                <th>Qty Pick</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function ambilStock() {
    let item_id = $('#item_id').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "/Packing/ambilStock",
        data: {
            Item_id: item_id,
            [crsfToken]: crsfHash,
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;
                $('#item_detail').val(data.item);
                $('#qty').val(data.qty);
                $('#qtyIn').focus();
            }
            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Barang kosong..',
                    text: response.error,
                });
                kosong();
                play_notifSalah();
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    $('#item_id').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilStock();
        }
    });
    $('#tambahItem').click(function(e) {
        e.preventDefault();
        let item_id = $('#item_id').val();
        let qtyIn = $('#qtyIn').val();

        if (qtyIn.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No Item Harus Di isi'
            });
            play_notifSalah();
        } else {
            $.ajax({
                type: "post",
                url: "/packing/simpanTemp",
                data: {
                    qtyIn: qtyIn,
                    item_id: item_id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        kosong();
                        dataTemp();
                        play_notif();
                    }
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Barang tidak boleh lebih'
                        });
                        play_notifSalah();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    });
});
</script>
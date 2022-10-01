<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\ModelLogInbound;
use App\Models\ModelStockDummy;
use App\Models\ModelWarehouse;
use App\Models\PoModel;
use App\Models\StockModel;
use App\Models\TempPO;
use App\Models\UploadPoModel;

class Inbound extends BaseController
{
    public function __construct()
    {
        $this->ModelInbound = new InboundModel();
        $this->ModelPo = new PoModel();
        $this->StockModel = new StockModel();
    }
    public function index()
    {
        $data = [
            'data'  => $this->ModelPo->tampilDataTransaksi(),
            'inbound' => $this->ModelInbound->tampilDataTransaksi(),
        ];

        return view('Stock/inbound', $data);
    }
    function detail()
    {
        if ($this->request->isAjax()) {
            $nopo = $this->request->getPost('nopo');
            $data = [
                'tampildatadetail'      => $this->ModelInbound->dataDetail($nopo),
                'detailin'              => $this->ModelInbound->getWhere(['nopo' => $nopo])
            ];
            $json = [
                'data'                  => view('Stock/modaldetailitem', $data)
            ];
            echo json_encode($json);
        }
    }
    function edit($nopo)
    {

        $noPo = $this->ModelInbound->cekFaktur($nopo);

        if ($noPo->getNumRows() > 0) {
            $row = $noPo->getRowArray();

            $data = [
                'nopo'      => $row['nopo'],
                'created_at'    => $row['created_at'],
                'warehouse' => $row['warehouse'],
                'datatemp' => $this->ModelInbound->getWhere(['nopo' => $nopo])->getResultArray(),
            ];
            return view('warehouse/inbound', $data);
        } else {
            exit('Data Tidak Ada');
        }
    }
    function cariDataSKU()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('Stock/modalCaribarang')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function detailCaribarang()
    {
        if ($this->request->isAJAX()) {
            $cari = $this->request->getPost('cari');
            $modelBarang = new UploadPoModel();
            $data = $modelBarang->tampildata_cari($cari)->get();
            if ($data != null) {
                $json = [
                    'data' => view(
                        '/Stock/detailCariBarang',
                        [
                            'tampildata' => $data
                        ]
                    )
                ];
                echo json_encode($json);
            }
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function ambilDataSKU()
    {
        if ($this->request->isAJAX()) {
            $ItemId = $this->request->getPost('ItemId');

            $ambilData = $this->ModelInbound->find($ItemId);

            if ($ambilData == null) {
                $json = [
                    'error' => 'data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'Item_detail' => $ambilData['Item_detail'],
                    'quantity' => $ambilData['quantity']
                ];

                $json = [
                    'sukses' => $data
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $nopo = $this->request->getPost('nopo');
            $modelTemp = new InboundModel();
            $data = [
                'datatemp' => $modelTemp->getWhere(['nopo' => $nopo]),

                'nopo'  => $nopo
            ];
            $json = [
                'data' => view('/warehouse/dataTemInbound', $data),

            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function simpanData()
    {
        $warehouse = $this->request->getVar('warehouse');
        $good = $this->request->getVar('good');
        $bad = $this->request->getVar('bad');
        $itemid = $this->request->getVar('itemid');
        $itemdetail = $this->request->getVar('itemdetail');
        $qty = $this->request->getVar('qty');
        $nopo = $this->request->getVar('nopo');

        $modalStock = new StockModel();
        $modelWh    = new ModelWarehouse();
        // $modalStockDumm = new ModelStockDummy();
        $count = count($itemid);

        $cekData = $modalStock->whereIn('sku', $itemid)->where('warehouse', $warehouse)->get()->getResult();
        $cekWh   = $modelWh->getWhere(['warehouse_name' => $warehouse])->getRow();
        $idwh    = $cekWh->id_warehouse;

        // $cekQty  = $cekData->quantity_good;
        // var_dump($cekData);
        // die;
        for ($i = 0; $i < $count; $i++) {
            $id =  $idwh . $itemid[$i];
            $cekId = $modalStock->getWhere(['Item_id' => $id])->getRow();

            if ($cekId == 0) {
                $data = [
                    'Item_id'       => $idwh . $itemid[$i],
                    'warehouse'     => $warehouse,
                    'sku'           => $itemid[$i],
                    'Item_detail'   => $itemdetail[$i],
                    'quantity_good' => $good[$i],
                    'quantity_reject'     => $bad[$i],
                ];
                $modalStock->insert($data);
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $cekQty = $modalStock->getWhere(['Item_id' => $idwh . $itemid[$i]])->getRow();
                    $idItem   = $idwh . $itemid[$i];

                    $data = [
                        'quantity_good'    => intval($good[$i]) + intval($cekQty->quantity_good),
                        'quantity_reject'  => intval($bad[$i]) + intval($cekQty->quantity_reject),
                    ];
                    $modalStock->update($idItem, $data);
                }
            }
        }

        $data4 = [
            'status'        => 2
        ];
        $this->ModelPo->update($nopo, $data4);
        $json = [
            'success'   => 'Berhasil Inbound',
        ];

        echo json_encode($json);
    }
    public function simpanInbound()
    {
        $good       = $this->request->getVar('qtyGood');
        $warehouse  = $this->request->getVar('warehouse');
        $bad        = $this->request->getVar('qtyBad');
        $itemid     = $this->request->getVar('itemid');
        $itemdetail = $this->request->getVar('itemdetail');
        $qty        = $this->request->getVar('qtyKirim');
        $nopo       = $this->request->getVar('nopo');
        $selisih    = $this->request->getVar('selisih');
        $reason     = $this->request->getVar('reason');

        $count      = count($itemid);
        $modalStock = new StockModel();
        $modalLog   = new ModelLogInbound();
        $modalPo    = new PoModel();
        $modalDumm  = new ModelStockDummy();
        $modalInbound  = new InboundModel();

        for ($h = 0; $h < $count; $h++) {
            $data5 = [
                'nopo'          => $nopo,
                'warehouse'     => $warehouse[$h],
                'Item_id'       => $itemid[$h],
                'Item_detail'   => $itemdetail[$h],
                'quantity'      => $qty[$h],
                'stock_good'    => $good[$h],
                'stock_bad'     => $bad[$h],
            ];
            $modalLog->insert($data5);
        }

        $cekNopo = $modalDumm->get()->getResultArray();

        $dataGagal = [];
        foreach ($cekNopo as $row) {
            $warehouse = $row['warehouse'];
            $item_id = $row['Item_id'];
            $item_detail = $row['Item_detail'];
            $qty     = $row['stock_good'];
            $qtyBad     = $row['stock_bad'];
            $date     = $row['created_at'];
            $kirim      = $row['quantity'];
            $no_po      = $row['nopo'];
            $cekData   = $modalStock->getWhere(['Item_id' => $item_id, 'warehouse' => $warehouse])->getResult();
            // var_dump(count($cekData));
            // die;
            if (count($cekData) > 0) {

                $dataGagal = count($cekData);
                $getStock = 0;
                foreach ($cekData as $data) {
                    $getStock = intval($data->quantity_good) + $qty;
                    $getbad = intval($data->quantity_reject) + $qtyBad;
                }

                $data2 = [
                    'quantity_good'     => intval($getStock),
                    'quantity_reject'   => intval($getbad),
                    'created_at'        => $date
                ];
                $this->StockModel->update($item_id, $data2);
                $json = [
                    'update'   => "stock berhasil di update",
                ];
            } else {
                $data = [
                    'Item_id'           => $item_id,
                    'warehouse'         => $warehouse,
                    'Item_detail'       => $item_detail,
                    'quantity_good'     => $qty,
                    'quantity_reject'   => $qtyBad,
                    'created_at'        => $date
                ];
                $this->StockModel->add($data);
                $json = [
                    'input'   => "stock berhasil di input",
                ];
            }
            $cekDataPo   = $modalDumm->getWhere(['nopo' => $no_po])->getResult();
            $sumCounting = 0;
            $sumSelisih = 0;
            foreach ($cekDataPo as $data) {
                $sumCounting += intval($data->stock_good) + intval($data->stock_bad);
                $sumSelisih += intval($data->quantity);
            }
            $data4 = [
                'quantity_count'    => $sumCounting,
                'selisih'           => $sumSelisih - $sumCounting
            ];
            $this->ModelPo->update($no_po, $data4);
        }
        $modalInbound->emptyTable();
        $modalDumm->emptyTable();

        echo json_encode($json);
    }
}
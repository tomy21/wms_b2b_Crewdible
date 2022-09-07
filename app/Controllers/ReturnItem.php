<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelOrder;
use App\Models\ModelReturn;
use App\Models\ModelReturnReject;
use App\Models\PickingModel;
use App\Models\StockModel;

class ReturnItem extends BaseController
{
    public function index()
    {

        $modelInvoice = new ModelReturn();
        $caridata       = $modelInvoice->tampilDataTransaksi();
        $data = [
            'data'    => $caridata
        ];
        return view('warehouse/listReturn', $data);
    }
    function dataReturn()
    {
        return view('warehouse/Returns');
    }
    function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $order = $this->request->getVar('OrderId');
            $modelTemp = new InvoiceModel();
            $cariData = $modelTemp->tampilDataTemp($order);
            if ($cariData == null) {
                $json = [
                    'error'     => 'Data picker tidak ada'
                ];
            } else {
                $data = [
                    'tampilData' => $cariData,
                    'OrderId'    => $order
                ];
                $json = [
                    'data' => view('warehouse/dataReturn', $data)
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function getDataReturn()
    {
        if ($this->request->isAJAX()) {
            $OrderId = $this->request->getVar('OrderId');

            $modelInvoice = new InvoiceModel();
            $caridata       = $modelInvoice->getWhere(['Order_id' => $OrderId]);
            $data = [
                'tampilData'    => $caridata
            ];
            $json = [
                'data'  => view('warehouse/Returns', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function simpanData()
    {
        if ($this->request->isAJAX()) {
            $order = $this->request->getPost('OrderId');
            $modelPacking   = new ModelReturn();
            $modelInvoice   = new InvoiceModel();
            $cekData        = $modelInvoice->cekOrder($order);
            $cek            = $modelInvoice->getWhere(['Order_id' => $order]);
            $status         = "Received";
            $received       = "Test 1";
            foreach ($cekData->getResultArray() as $row) :
                $OrderId        = $row['Order_id'];
                $ItemId         = $row['Item_id'];
                $ItemDetail     = $row['Item_detail'];
                $qty            = $row['quantity'];

                $data = [
                    'Order_id'          => $order,
                    'Item_id'           => $ItemId,
                    'Item_detail'       => $ItemDetail,
                    'qty'               => $qty,
                    'Receive'           => $received,
                    'Status'            => $status
                ];
                $modelPacking->insert($data);
            endforeach;


            $json = [
                'sukses' => 'item berhasil ditambah'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function detail()
    {
        if ($this->request->isAjax()) {
            $idItem = $this->request->getPost('idItem');

            $modelReturn = new ModelReturn();
            $ambilData = $modelReturn->find($idItem);
            $data = [
                'ItemId'        => $idItem,
                'ItemDetail'    => $ambilData['Item_detail'],
                'quantity'      => $ambilData['qty'],
                'OrderID'       => $ambilData['Order_id'],
            ];
            $json = [
                'data'                  => view('warehouse/modalPickup', $data)
            ];
            echo json_encode($json);
        }
    }
    function detailRtn()
    {
        if ($this->request->isAjax()) {
            $idItem = $this->request->getPost('idItem');

            $modelReturn = new ModelReturn();
            $ambilData = $modelReturn->find($idItem);
            $data = [

                'ItemId'        => $idItem,
                'ItemDetail'    => $ambilData['Item_detail'],
                'quantity'      => $ambilData['qty'],
                'OrderID'       => $ambilData['Order_id'],
            ];
            $json = [
                'data'          => view('warehouse/modalReject', $data)
            ];
            echo json_encode($json);
        }
    }
    function inputDataRtn()
    {
        if ($this->request->isAjax()) {
            $ItemId         = $this->request->getPost('ItemId');
            $ItemDetail     = $this->request->getPost('ItemDetail');
            $qty            = $this->request->getPost('qty');
            $reason         = $this->request->getPost('reason');
            $OrderId        = $this->request->getPost('OrderId');
            $receive        = $this->request->getPost('receive');

            $modelStock = new StockModel();
            $modelReturn = new ModelReturn();
            $modaInv    = new InvoiceModel();
            $orderModel = new ModelOrder();
            $cariStock  = $modelStock->find($ItemId);
            $qtyStock   = $cariStock['quantity_reject'];
            $resultStock    = intval($qtyStock) + intval($qty);

            $data   = [
                'quantity_reject'  => $resultStock
            ];
            $data2  = [
                'Status'    => 8,
                'Reason'    => $reason
            ];
            $data3  = [
                'status'    => 8,
            ];

            $modelStock->update($ItemId, $data);
            $modelReturn->update($ItemId, $data2);
            $modaInv->update($OrderId, $data3);
            $orderModel->update($OrderId, $data3);

            $Modelreject = new ModelReturnReject();
            $Modelreject->insert([
                'Order_id'          => $OrderId,
                'Item_id'           => $ItemId,
                'Item_detail'       => $ItemDetail,
                'qty'               => $qty,
                'Receive'           => $receive,
                'Status'            => 6
            ]);

            $json = [
                'sukses'    => 'Data Berhasil Masuk Kestock'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function inputData()
    {
        if ($this->request->isAjax()) {
            $ItemId         = $this->request->getPost('ItemId');
            $ItemDetail     = $this->request->getPost('ItemDetail');
            $qty            = $this->request->getPost('qty');
            $reason         = $this->request->getPost('reason');
            $OrderId        = $this->request->getPost('OrderId');

            $modelStock = new StockModel();
            $modelReturn = new ModelReturn();
            $modaInv    = new InvoiceModel();
            $orderModel = new ModelOrder();
            $cariStock  = $modelStock->find($ItemId);
            $qtyStock   = $cariStock['quantity_good'];
            $resultStock    = intval($qtyStock) + intval($qty);

            $data   = [
                'quantity_good'  => $resultStock
            ];
            $data2  = [
                'Status'    => 8,
                'Reason'    => $reason
            ];
            $data3  = [
                'status'    => 6,
            ];

            $modelStock->update($ItemId, $data);
            $modelReturn->update($ItemId, $data2);
            $modaInv->update($OrderId, $data3);
            $orderModel->update($OrderId, $data3);

            $json = [
                'sukses'    => 'Data Berhasil Masuk Kestock'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
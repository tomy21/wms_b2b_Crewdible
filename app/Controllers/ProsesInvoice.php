<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\InvoiceModel;
use App\Models\ModelItemTemp;
use App\Models\ModelKaryawan;
use App\Models\ModelOrder;
use App\Models\PickingModel;
use Config\Services;

class ProsesInvoice extends BaseController
{
    public function __construct()
    {
        $this->ModelInvoice     = new InvoiceModel();
    }

    public function index()
    {
        $request = Services::request();
        $ModelInvoice   = new InvoiceModel();
        $modelOrder     = new ModelOrder($request);
        $sum            = $ModelInvoice->sumData();
        $cekData        = $modelOrder->getWhere(['status' => 1]);
        $jumlah = 0;
        foreach ($sum->getResultArray() as $row) :
            $jumlah += intval($row['quantity']);
        endforeach;

        $data = [
            'countOrder'      => $cekData->getNumRows(),
            // 'assign'    => $modalPick->tampilData(),
            // 'dataKar'            => $modalPick->tampilData(),
            'total'              => $jumlah,
            // 'totalKapasitas'     => $totalKapasitas,
            // 'totalBasket'     => $totalKapasitas / 15,
            // 'totalBasketkapasitas'     => $totalKapasitasBasket,
        ];
        return view('basket/index', $data);
    }
    public function data()
    {
        $ModelPicking = new PickingModel();
        $modalPick    = new ModelKaryawan();
        $warehouse = user()->warehouse;
        $data = [
            'data'      => $ModelPicking->tampilDataTransaksi($warehouse),
            'dataKar'   => $modalPick->tampilData($warehouse)
        ];
        return view('Stock/data', $data);
    }

    public function detail()
    {
        if ($this->request->isAjax()) {
            $order = $this->request->getVar('order');

            $modelInbound = new InvoiceModel();
            $data = [
                'detailin'              => $modelInbound->dataDetail($order),
                'NoOrder'               => $order
            ];
            $json = [
                'data'                  => view('Stock/modalDetail', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
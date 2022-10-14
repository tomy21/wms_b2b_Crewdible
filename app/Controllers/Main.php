<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelOrder;
use App\Models\StockModel;


class Main extends BaseController
{
    public function index()
    {
        $ModelInvoice = new ModelOrder();
        $ModelStock = new StockModel();
        $Totnew = $ModelInvoice->getWhere(['status' => 1]);
        $new = $Totnew->getNumRows();

        $Totpick = $ModelInvoice->getWhere(['status' => 3]);
        $pick = $Totpick->getNumRows();

        $Totpack = $ModelInvoice->getWhere(['status' => 4]);
        $pack = $Totpack->getNumRows();

        $brand4    = 4;
        $Totrtn = $ModelInvoice->getWhere(['status' => $brand4]);
        $rtn = $Totrtn->getNumRows();

        $brand5    = 6;
        $Totrtn = $ModelInvoice->getWhere(['status' => $brand5]);
        $assign = $Totrtn->getNumRows();

        $Totnew = $ModelInvoice->getWhere(['status' => 5]);
        $done = $Totnew->getNumRows();

        $transaksi = $ModelInvoice->findAll();
        $total      = count($transaksi);

        $Stock = $ModelStock->findAll();
        $StockData = count($Stock);

        $result = $ModelStock->select('sum(quantity_good) as sumQuantities')->first();
        $data['sum'] = $result['sumQuantities'];

        $modelInvoice = new InvoiceModel();
        $modelOrder = new ModelOrder();
        $cekWarehouse = $modelOrder->findAll();

        $data = [
            'total'     => $total,
            // 'data'      => $ModelInvoice->getDataCount(),
            'new'       => $new,
            'picking'   => $pick,
            'packing'   => $pack,
            'return'    => $rtn,
            'Assign'    => $assign,
            'done'      => $done,
            'stockData' => $StockData,
            'qtyStock'  => $data['sum'] = $result['sumQuantities'],
            'warehouse'     => $modelInvoice->dataSummary(),
            // 'config' => config('Auth'),
        ];
        return view('Layout/Dashboard', $data);
    }
}
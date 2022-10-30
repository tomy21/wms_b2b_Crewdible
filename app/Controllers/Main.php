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
        $Totnew = $ModelInvoice->getWhere(['status' => 1, 'created_at' => date('Y-m-d')]);
        $new = $Totnew->getNumRows();

        $Totpick = $ModelInvoice->getWhere(['status' => 3, 'created_at' => date('Y-m-d')]);
        $pick = $Totpick->getNumRows();

        $Totpack = $ModelInvoice->getWhere(['status' => 4, 'created_at' => date('Y-m-d')]);
        $pack = $Totpack->getNumRows();

        $shipping = $ModelInvoice->getWhere(['status' => 5, 'created_at' => date('Y-m-d')]);
        $shipp = $shipping->getNumRows();

        $done = $ModelInvoice->getWhere(['status' => 6, 'created_at' => date('Y-m-d')]);
        $done = $done->getNumRows();
        $rtnData = $ModelInvoice->getWhere(['status' => 7, 'created_at' => date('Y-m-d')]);
        $rtn = $rtnData->getNumRows();

        $Totnew = $ModelInvoice->getWhere(['status' => 2, 'created_at' => date('Y-m-d')]);
        $assign = $Totnew->getNumRows();

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
            'shipping'  => $shipp,
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
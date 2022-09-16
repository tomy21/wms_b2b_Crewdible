<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\StockModel;


class Main extends BaseController
{
    public function index()
    {
        $ModelInvoice = new InvoiceModel();
        $ModelStock = new StockModel();
        $Totnew = $ModelInvoice->getWhere(['status' => 1]);
        $new = $Totnew->getNumRows();

        $brand2    = 2;
        $Totpick = $ModelInvoice->getWhere(['status' => $brand2]);
        $pick = $Totpick->getNumRows();

        $brand3    = 3;
        $Totpack = $ModelInvoice->getWhere(['status' => $brand3]);
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
            // 'config' => config('Auth'),
        ];
        return view('Layout/Dashboard', $data);
    }
}
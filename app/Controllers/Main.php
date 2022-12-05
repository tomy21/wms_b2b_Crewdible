<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelListHandover;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use App\Models\PoModel;
use App\Models\StockModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Config\Services;

class Main extends BaseController
{
    public function index()
    {
        $request = Services::request();
        $ModelInvoice = new ModelOrder($request);
        $ModelStock = new StockModel();
        $Totnew = $ModelInvoice->where(['status' => 1, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $Totpick = $ModelInvoice->where(['status' => 3, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $Totpack = $ModelInvoice->where(['status' => 4, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $shipping = $ModelInvoice->where(['status' => 5, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $done = $ModelInvoice->where(['status' => 6, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $rtnData = $ModelInvoice->where(['status' => 7, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $assign = $ModelInvoice->where(['status' => 2, 'created_at>=' => date('Y-m-d')])->countAllResults();
        $transaksi = $ModelInvoice->where(['created_at>=' => date('Y-m-d')])->countAllResults();


        $Stock = $ModelStock->findAll();
        $StockData = count($Stock);

        $result = $ModelStock->select('sum(quantity_good) as sumQuantities')->first();
        $data['sum'] = $result['sumQuantities'];

        $modelInvoice = new InvoiceModel();
        $modelOrder = new ModelOrder($request);
        $dataQuery  = $modelOrder->groupBy('stock_location')->get()->getResult();
        // $countSLA = count($sla);

        $data = [
            'total'     => $transaksi,
            'new'       => $Totnew,
            'picking'   => $Totpick,
            'packing'   => $Totpack,
            'return'    => $rtnData,
            'shipping'  => $shipping,
            'Assign'    => $assign,
            'done'      => $done,
            'stockData' => $StockData,
            'qtyStock'  => $data['sum'] = $result['sumQuantities'],
            'warehouse' => $modelInvoice->dataSummary(),
            'dataOrder'     => $dataQuery,
            // 'config' => config('Auth'),
        ];
        return view('Layout/Dashboard', $data);
    }

    function dashboardData()
    {
        $request = Services::request();
        $start      = $this->request->getPost('start');
        $end        = $this->request->getPost('end');

        $modelOrder = new ModelOrder($request);
        $transaksi  = $modelOrder->where('status',1)->where('created_at BETWEEN "' . $start . '" AND "' . $end . '"')->countAllResults();
        $assign     = $modelOrder->where('status',2)->where('created_at BETWEEN "' . $start . '" AND "' . $end . '"')->countAllResults();
        $transaksi  = $modelOrder->where('status',3)->where('created_at BETWEEN "' . $start . '" AND "' . $end . '"')->countAllResults();
        $transaksi  = $modelOrder->where('status',4)->where('created_at BETWEEN "' . $start . '" AND "' . $end . '"')->countAllResults();
        $transaksi  = $modelOrder->where('status',5)->where('created_at BETWEEN "' . $start . '" AND "' . $end . '"')->countAllResults();
        $transaksi  = $modelOrder->where('status',6)->where('created_at BETWEEN "' . $start . '" AND "' . $end . '"')->countAllResults();
    }
}
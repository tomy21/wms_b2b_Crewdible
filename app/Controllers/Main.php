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


class Main extends BaseController
{
    public function index()
    {
        $ModelInvoice = new ModelOrder();
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
        $modelOrder = new ModelOrder();

        // $countSLA = count($sla);

        $data = [
            'total'     => $transaksi,
            // 'data'      => $ModelInvoice->getDataCount(),
            'new'       => $Totnew,
            'picking'   => $Totpick,
            'packing'   => $Totpack,
            'return'    => $rtnData,
            'shipping'  => $shipping,
            'Assign'    => $assign,
            'done'      => $done,
            'stockData' => $StockData,
            'qtyStock'  => $data['sum'] = $result['sumQuantities'],
            'warehouse'     => $modelInvoice->dataSummary(),
            // 'config' => config('Auth'),
        ];
        return view('Layout/Dashboard', $data);
    }
    function downloadOutbound(){

        $tglawal        = $this->request->getPost('valAwalOut');
        $tglakhir       = $this->request->getPost('valAkhirOut');

        $spreadsheet = new Spreadsheet();
        $modelBarang = new ModelOrder();
        $dataReport = $modelBarang->reportPeriode($tglawal, $tglakhir);

        // $id = null;
        $orderId = null;
        foreach($dataReport->getResult() as $x){
            // $id = $x->id;
            $orderId = $x->Order_id;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Data OutBound");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "No");
        $sheet->setCellValue('B3', "Warehouse");
        $sheet->setCellValue('C3', "Order Id");
        $sheet->setCellValue('D3', "Sum Quantity Order");
        $sheet->setCellValue('E3', "Sum Quantity Packing");
        $sheet->setCellValue('F3', "Count Items Order");
        $sheet->setCellValue('G3', "Count Items Packing");
        $sheet->setCellValue('H3', "Date Slot");
        $sheet->setCellValue('I3', "Selesai Packing");
        $sheet->setCellValue('J3', "Selesai Handover");
        $sheet->setCellValue('K3', "SLA");

        $no = 1;
        $numrow = 4;
        foreach ($dataReport->getResult() as $row) :

            // data invoice 
            $modelInvoice = new InvoiceModel();
            $count = $modelInvoice->where(['Order_id' => $row->Order_id])->countAllResults();
            $sumData = 0;
            $idInv = [];
            $query = $modelInvoice->where(['Order_id' => $row->Order_id])->get()->getResult();
            foreach ($query as $x) {
                $sumData += $x->quantity;
                $idInv = $x->id;
            }

            // data Packing
            $modelPacking = new PackingModel();
            $queryPacking = $modelPacking->getWhere(['order_id' => $row->Order_id])->getResult();
            $sumPacking = 0;
            $countPacking = 0;
            $datePacking = [];
            foreach ($queryPacking as $z) {
                foreach (json_decode($z->row) as $y) {
                    $sumPacking += intval($y->quantity);
                }
                $jsonData = json_decode($z->row, true);
                $countPacking = count($jsonData);
                $datePacking = $z->updated_at;
            }

            // date Handover 
            $modelHandover = new ModelListHandover();
            $queryHandover = $modelHandover->getWhere(['order_id' => $row->Order_id])->getResult();
            $updatedHandover = [];
            foreach ($queryHandover as $p) {
                $updatedHandover = $p->updated_at;
            }

            $sheet->setCellValue('A' . $numrow, '1');
            $sheet->setCellValue('B' . $numrow, $row->stock_location);
            $sheet->setCellValue('C' . $numrow, $row->Order_id);
            $sheet->setCellValue('D' . $numrow, $sumData);
            $sheet->setCellValue('E' . $numrow, $sumPacking);
            $sheet->setCellValue('F' . $numrow, $count);
            $sheet->setCellValue('G' . $numrow, $countPacking);
            $sheet->setCellValue('H' . $numrow, $row->created_at);
            $sheet->setCellValue('I' . $numrow, $updatedHandover);
            $sheet->setCellValue('J' . $numrow, $row->created_at <= $datePacking ? "<span class=\" badge badge-danger\">Over SLA</span>" : "<span class=\"badge badge-success\">Meet SLA</span>");

            $no++;
            $numrow++;
        endforeach;

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Tamplate Input Inbound';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

        $tglawal        = $this->request->getPost('tglAwalOut');
        $tglakhir       = $this->request->getPost('tglAkhirOut');

        $modelOutbound = new InvoiceModel();

        $reportOut = $modelOutbound->reportPeriode($tglawal, $tglakhir);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Data Barang Keluar");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "No");
        $sheet->setCellValue('B3', "Tanggal Masuk");
        $sheet->setCellValue('C3', "No SKU");
        $sheet->setCellValue('D3', "Nama Barang");
        $sheet->setCellValue('E3', "Quantity");

        $no = 1;
        $numrow = 4;
        foreach ($reportOut->getResultArray() as $row) :
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $row['created_at']);
            $sheet->setCellValue('C' . $numrow, $row['codeSKU']);
            $sheet->setCellValue('D' . $numrow, $row['namaSKU']);
            $sheet->setCellValue('E' . $numrow, $row['quantity']);

            $no++;
            $numrow++;
        endforeach;


        $sheet->getDefaultRowDimension()->getRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle('Laporan Barang Keluar');

        header('Content-Type : application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename = "LaporanBarangKeluar.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
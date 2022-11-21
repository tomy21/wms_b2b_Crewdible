<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\InvoiceModel;
use App\Models\ModelListHandover;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use App\Models\PickingModel;
use App\Models\PoModel;
use Config\Services;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class Laporan extends BaseController
{
    public function index()
    {
        

        return view('Laporan/index');
    }
    public function cetakReportInbound()
    {
        $tglawal        = $this->request->getPost('valAwalIn');
        $tglakhir       = $this->request->getPost('valAkhirIn');

        $tglakhir = date("Y-m-d", strtotime($tglakhir));
        $tglawal = date("Y-m-d", strtotime($tglawal));

        $request = Services::request();
        $modelPO = new PoModel($request);
        $query = $modelPO->where('created_at BETWEEN "' . $tglawal . '" AND "' . $tglakhir . '"')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Data Inbound $tglawal - $tglakhir");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A3', "No");
        $sheet->setCellValue('B3', "Warehouse");
        $sheet->setCellValue('C3', "No PO");
        $sheet->setCellValue('D3', "Total SKU");
        $sheet->setCellValue('E3', "Total Qty");
        $sheet->setCellValue('F3', "Nama Driver");
        $sheet->setCellValue('G3', "No Pelat Kendaraan");
        $sheet->setCellValue('H3', "Kedatangan Driver");
        $sheet->setCellValue('I3', "Tanggal Input to stock");
        $sheet->setCellValue('J3', "SLA");

        $no = 1;
        $column = 4;
        foreach ($query->getResultArray() as $x) {
            
            //inbound 
            $modelInbound = new InboundModel();
            $jumlahQtyPO = $modelInbound->where(['nopo'=>$x['no_Po']])->countAllResults();

            $date2 = date_create($x['waktu_datang']);
            $dateFormat1 = date_format($date2, 'Y-m-d 23:59:00');
            $dateFormat2 = date_format($date2, 'Y-m-d 18:00:00');
            if ($x['waktu_datang'] <= $dateFormat2 && $x['updated_at'] > $dateFormat1) {
                $sla = 'Over SLA';
            } else {
                $sla = 'Meet SLA';
            }

            $sheet->setCellValue('A' . $column, $no);
            $sheet->setCellValue('B' . $column, $x['warehouse']);
            $sheet->setCellValue('C' . $column, $x['no_Po']);
            $sheet->setCellValue('D' . $column, $jumlahQtyPO);
            $sheet->setCellValue('E' . $column, $x['quantity_item']);
            $sheet->setCellValue('F' . $column, $x['driver']);
            $sheet->setCellValue('G' . $column, $x['noplat']);
            $sheet->setCellValue('H' . $column, $x['waktu_datang']);
            $sheet->setCellValue('I' . $column, $x['updated_at']);
            $sheet->setCellValue('J' . $column, $sla);
            
            $column++;
            $no++;
        }


        $writer = new Xlsx($spreadsheet);
        $fileName = "Data Inbound $tglawal - $tglakhir";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function cetakReportOutbound()
    {
        $tglawal        = $this->request->getPost('valAwalOut');
        $tglakhir       = $this->request->getPost('valAkhirOut');

        $tglakhir = date("Y-m-d", strtotime($tglakhir));
        $tglawal = date("Y-m-d", strtotime($tglawal));

        $request = Services::request();
        $modalOrder = new ModelOrder($request);
        $query = $modalOrder->where('created_at BETWEEN "'.$tglawal.'" AND "'.$tglakhir.'"')->get();

        // var_dump($query->getResult());
        // die;



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Data Outbound $tglawal - $tglakhir");
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
        $column = 4;
        foreach ($query->getResultArray() as $x) {
            // data invoice 
            $modelInvoice = new InvoiceModel();
            $count = $modelInvoice->where(['Order_id' => $x['Order_id']])->countAllResults();
            $sumData = 0;
            $idInv = null;
            $query = $modelInvoice->where(['Order_id' => $x['Order_id']])->get()->getResult();
            foreach ($query as $h) {
                $sumData += $h->quantity;
                $idInv = $h->id;
            }

            // data Packing
            $modelPacking = new PackingModel($request);
            $queryPacking = $modelPacking->where('order_id', $x['Order_id'])->get()->getResult();
            $sumPacking = 0;
            $countPacking = 0;
            $datePacking = null;
            foreach ($queryPacking as $z) {
                foreach (json_decode($z->list) as $y) {
                    $sumPacking += intval($y->quantity);
                }
                $jsonData = json_decode($z->list, true);
                $countPacking = count($jsonData);
                $datePacking = $z->updated_at;
            }

            // date Handover 
            $modelHandover = new ModelListHandover();
            $queryHandover = $modelHandover->getWhere(['order_id' => $x['Order_id']])->getResult();
            $updatedHandover = null;
            foreach ($queryHandover as $p) {
                $updatedHandover = $p->updated_at;
            }


            $sheet->setCellValue('A' . $column, $no);
            $sheet->setCellValue('B' . $column, $x['stock_location']);
            $sheet->setCellValue('C' . $column, $x['Order_id']);
            $sheet->setCellValue('D' . $column, $sumData);
            $sheet->setCellValue('E' . $column, $sumPacking);
            $sheet->setCellValue('F' . $column, $count);
            $sheet->setCellValue('G' . $column, $countPacking);
            $sheet->setCellValue('H' . $column, $x['created_at']);
            $sheet->setCellValue('I' . $column, $datePacking);
            $sheet->setCellValue('J' . $column, $updatedHandover);
            $sheet->setCellValue('K' . $column, $x['created_at'] <= $datePacking ? "OverSLA" : "MeetSLA");

            $column++;
            $no++;
        }
        

        $writer = new Xlsx($spreadsheet);
        $fileName = "Data Outbound $tglawal - $tglakhir";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }
    // function tampilGrafikBarangMasuk()
    // {
    //     $bulan = $this->request->getPost('bulan');
    //     $db = \Config\Database::connect();
    //     $query = $db->query("SELECT created_at AS tgl, quantity FROM tbl_invoice wHERE DATE_FORMAT(created_at, '%Y-%m')='$bulan' ORDER BY created_at ASC")->getResult();

    //     $data = [
    //         'grafik'        => $query
    //     ];
    //     $json = [
    //         'data'          => view('layout/grafikLaporan', $data)
    //     ];

    //     echo json_encode($json);
    // }
}
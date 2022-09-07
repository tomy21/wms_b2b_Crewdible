<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Controllers\Xlsx;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use App\Models\PickingModel;

class Laporan extends BaseController
{
    public function index()
    {
        $modelOrder = new ModelOrder();
        $modelPacking = new PackingModel();
        $modelPicking = new PickingModel();
        $tanggalAwal = $this->request->getVar('tglAwal');
        $tanggalAkhir = $this->request->getVar('tglAkhir');

        if ($tanggalAwal == null && $tanggalAkhir == null) {
            $order = $modelOrder->where('status', 7)->get();
        } else {
            $order = $modelOrder->where('created_at>=', $tanggalAwal)->where('created_at<=', $tanggalAkhir)->get();
        }

        $data = [
            'data'  => $order,
        ];


        return view('Laporan/index', $data);
    }
    // public function cetakReportInbound()
    // {
    //     $tglawal        = $this->request->getPost('tglAwal');
    //     $tglakhir       = $this->request->getPost('tglAkhir');

    //     $modelBarang    = new InvoiceModel();

    //     $dataReport = $modelBarang->reportPeriode($tglawal, $tglakhir);


    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', "Data Barang Masuk");
    //     $sheet->mergeCells('A1:E1');
    //     $sheet->getStyle('A1')->getFont()->setBold(true);
    //     $sheet->setCellValue('A3', "No");
    //     $sheet->setCellValue('B3', "Tanggal Masuk");
    //     $sheet->setCellValue('C3', "No SKU");
    //     $sheet->setCellValue('D3', "Nama Barang");
    //     $sheet->setCellValue('E3', "Quantity");

    //     $no = 1;
    //     $numrow = 4;
    //     foreach ($dataReport->getResultArray() as $row) :
    //         $sheet->setCellValue('A' . $numrow, $no);
    //         $sheet->setCellValue('B' . $numrow, $row['created_at']);
    //         $sheet->setCellValue('C' . $numrow, $row['incodeSKU']);
    //         $sheet->setCellValue('D' . $numrow, $row['innamaSKU']);
    //         $sheet->setCellValue('E' . $numrow, $row['quantity']);

    //         $no++;
    //         $numrow++;
    //     endforeach;


    //     $sheet->getDefaultRowDimension()->getRowHeight(-1);
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->setTitle('Laporan Barang Masuk');

    //     header('Content-Type : application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename = "LaporanBarangMasuk.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    // }
    // public function cetakReportOutbound()
    // {
    //     $tglawal        = $this->request->getPost('tglAwalOut');
    //     $tglakhir       = $this->request->getPost('tglAkhirOut');

    //     $modelOutbound = new InvoiceModel();

    //     $reportOut = $modelOutbound->reportPeriode($tglawal, $tglakhir);
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', "Data Barang Keluar");
    //     $sheet->mergeCells('A1:E1');
    //     $sheet->getStyle('A1')->getFont()->setBold(true);
    //     $sheet->setCellValue('A3', "No");
    //     $sheet->setCellValue('B3', "Tanggal Masuk");
    //     $sheet->setCellValue('C3', "No SKU");
    //     $sheet->setCellValue('D3', "Nama Barang");
    //     $sheet->setCellValue('E3', "Quantity");

    //     $no = 1;
    //     $numrow = 4;
    //     foreach ($reportOut->getResultArray() as $row) :
    //         $sheet->setCellValue('A' . $numrow, $no);
    //         $sheet->setCellValue('B' . $numrow, $row['created_at']);
    //         $sheet->setCellValue('C' . $numrow, $row['codeSKU']);
    //         $sheet->setCellValue('D' . $numrow, $row['namaSKU']);
    //         $sheet->setCellValue('E' . $numrow, $row['quantity']);

    //         $no++;
    //         $numrow++;
    //     endforeach;


    //     $sheet->getDefaultRowDimension()->getRowHeight(-1);
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->setTitle('Laporan Barang Keluar');

    //     header('Content-Type : application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename = "LaporanBarangKeluar.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    // }
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
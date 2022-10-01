<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelItem;
use App\Models\ModelOrder;
use App\Models\StockModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Invoice extends BaseController
{
    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->ModalOrder   = new ModelOrder();
        $this->ModelStock    = new StockModel();
    }
    public function index()
    {


        $data = [
            'status'    => $this->ModalOrder->get()->getResult(),
        ];


        return view('Stock/invoice', $data);
    }
    public function upload()
    {

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'fileimport' => [
                'label'     => 'Input Data Transaksi',
                'rules'     => 'uploaded[fileimport]|ext_in[fileimport,xls,xlsx]',
                'errors'     => [
                    'uploaddata' => '{field} data harus diisi',
                    'ext_in'     => '{field} format harus xlx atau xlxs'
                ]
            ]
        ]);

        if (!$valid) {
            $sess_pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
            <h5><i class="icon fa fa-ban"></i> Error ! </h5>
            ' . $validation->listErrors() . '
            </div>'
            ];
            session()->setFlashdata($sess_pesan);
            return redirect()->to('/Invoice');
        } else {
            $file_upload = $this->request->getFile('fileimport');
            $date = $this->request->getPost('tglupload');
            $slot = $this->request->getPost('slot');
            $ext = $file_upload->getClientExtension();

            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file_upload);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            $itemTemp = [];
            $orderNow = null;
            $orderNow2 = null;
            $countRow = count($sheet);
            $htmlError = '';
            foreach ($sheet as $x => $row) {
                if ($x == 0) {
                    continue;
                }
                // dd($x = 1);
                // die;
                $jumlah = 0;
                $Order_ID           = $row[0];
                $Item_ID            = $row[1];
                $Item_Detail        = $row[2];
                $Quantity           = $row[3];
                $Volume             = $row[4];
                $Vehicle            = $row[5];
                $Drop_Name          = $row[6];
                $Drop_Contact       = $row[7];
                $Drop_Address       = $row[8];
                $Drop_City          = $row[9];
                $Drop_Country       = $row[10];
                $Drop_Zipcode       = $row[11];
                $Drop_Latitude      = $row[12];
                $Drop_Longitude     = $row[13];
                $Transaction_date   = $row[14];
                $Drop_Date          = $row[15];
                $Drop_Start_Time    = $row[16];
                $Drop_End_Time      = $row[17];
                $Payment_Method     = $row[18];
                $Amount             = $row[19];
                $Note               = $row[20];
                $Stock_Location     = $row[21];

                if ($slot == 1) {
                    $date = date('Y-m-d 08:15:00', strtotime('+1 days'));
                } else {
                    $date = date('Y-m-d 14:15:00', strtotime('+1 days'));
                }
                if ($orderNow == null || $orderNow['Order_id'] == $Order_ID) {

                    $itemTemp[] = [
                        'Order_id'          => $Order_ID,
                        'Drop_name'         => $Drop_Name,
                        'Drop_contact'      => $Drop_Contact,
                        'Drop_address'      => $Drop_Address,
                        'Drop_city'         => $Drop_City,
                        'Drop_country'      => $Drop_Country,
                        'Drop_zipcode'      => $Drop_Zipcode,
                        'Drop_latitude'     => $Drop_Latitude,
                        'Drop_longitude'    => $Drop_Longitude,
                        'Transaction_time'  => $Transaction_date,
                        'Drop_date'         => $Drop_Date,
                        'Drop_start_time'   => $Drop_Start_Time,
                        'Drop_end_time'     => $Drop_End_Time,
                        'Payment_methode'   => $Payment_Method,
                        'stock_location'    => $Stock_Location,
                        'Item_id'           => $Item_ID,
                        'Item_detail'       => $Item_Detail,
                        'quantity'          => $Quantity,
                        'volume'            => $Volume,
                        'Vehicle_tag'       => $Vehicle,
                        'Amount'            => $Amount,
                        'Note'              => $Note,
                        'status'            => 1,
                        'slot'              => $slot,
                        'created_at'        => $date,
                    ];
                    if (($x + 1) == $countRow) {
                        $cekStock = $this->countStock($itemTemp, $orderNow, $orderNow2);
                        $htmlError .= $cekStock;
                    }
                } else if (($x + 1) == $countRow) {
                    $cekStock = $this->countStock($itemTemp, $orderNow, $orderNow2);
                    $htmlError .= $cekStock;
                } else {
                    $cekStock = $this->countStock($itemTemp, $orderNow, $orderNow2);
                    $htmlError .= $cekStock;

                    $itemTemp = [];
                    $itemTemp[] = [
                        'Order_id'          => $Order_ID,
                        'Drop_name'         => $Drop_Name,
                        'Drop_contact'      => $Drop_Contact,
                        'Drop_address'      => $Drop_Address,
                        'Drop_city'         => $Drop_City,
                        'Drop_country'      => $Drop_Country,
                        'Drop_zipcode'      => $Drop_Zipcode,
                        'Drop_latitude'     => $Drop_Latitude,
                        'Drop_longitude'    => $Drop_Longitude,
                        'Transaction_time'  => $Transaction_date,
                        'Drop_date'         => $Drop_Date,
                        'Drop_start_time'   => $Drop_Start_Time,
                        'Drop_end_time'     => $Drop_End_Time,
                        'Payment_methode'   => $Payment_Method,
                        'stock_location'    => $Stock_Location,
                        'Item_id'           => $Item_ID,
                        'Item_detail'       => $Item_Detail,
                        'quantity'          => $Quantity,
                        'volume'            => $Volume,
                        'Vehicle_tag'       => $Vehicle,
                        'Amount'            => $Amount,
                        'Note'              => $Note,
                        'status'            => 1,
                        'slot'              => $slot,
                        'created_at'        => $date,
                    ];
                }

                $orderNow = [
                    'Order_id'          => $Order_ID,
                    'Drop_name'         => $Drop_Name,
                    'Drop_contact'      => $Drop_Contact,
                    'Drop_address'      => $Drop_Address,
                    'Drop_city'         => $Drop_City,
                    'Drop_country'      => $Drop_Country,
                    'Drop_zipcode'      => $Drop_Zipcode,
                    'Drop_latitude'     => $Drop_Latitude,
                    'Drop_longitude'    => $Drop_Longitude,
                    'Transaction_time'  => $Transaction_date,
                    'Drop_date'         => $Drop_Date,
                    'Drop_start_time'   => $Drop_Start_Time,
                    'Drop_end_time'     => $Drop_End_Time,
                    'Payment_methode'   => $Payment_Method,
                    'stock_location'    => $Stock_Location,
                    'Item_id'           => $Item_ID,
                    'Item_detail'       => $Item_Detail,
                    'quantity'          => $Quantity,
                    'volume'            => $Volume,
                    'Vehicle_tag'       => $Vehicle,
                    'Amount'            => $Amount,
                    'Note'              => $Note,
                    'status'            => 1,
                    'slot'              => $slot,
                    'created_at'        => $date,
                ];

                $orderNow2 = [
                    'Order_id'          => $Order_ID,
                    'Drop_name'         => $Drop_Name,
                    'Drop_contact'      => $Drop_Contact,
                    'Drop_address'      => $Drop_Address,
                    'Drop_city'         => $Drop_City,
                    'Drop_country'      => $Drop_Country,
                    'Drop_zipcode'      => $Drop_Zipcode,
                    'Drop_latitude'     => $Drop_Latitude,
                    'Drop_longitude'    => $Drop_Longitude,
                    'Transaction_time'  => $Transaction_date,
                    'Drop_date'         => $Drop_Date,
                    'Drop_start_time'   => $Drop_Start_Time,
                    'Drop_end_time'     => $Drop_End_Time,
                    'Payment_methode'   => $Payment_Method,
                    'stock_location'    => $Stock_Location,
                    'note'              => $Note,
                    'Status'            => 1,
                    'created_at'        => $date

                ];
            }
            session()->setFlashdata('error', $htmlError);
            return redirect()->to('/Invoice/index');
        }
    }
    function countStock($itemTemp, $orderNow, $orderNow2)
    {
        $validate = true;
        $updateItem = [];
        $htmlError = '';
        foreach ($itemTemp as $item) {
            $db = \Config\Database::connect();
            $cekCode = $db->table('tbl_stock')->getWhere(['sku' => $item['Item_id'], 'warehouse' => $item['stock_location']])->getRow();
            $cekOrder = $db->table('tbl_order')->getWhere(['Order_id' => $item['Order_id']])->getRow();

            if ($cekOrder != null) {
                $htmlError .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5><i class="icon fas fa-times"></i> Gagal </h5>
                            Order ' . $item['Order_id'] . ' Sudah Ada.
                            </div>';
                $validate = false;
                break;
            } else {
                if (!is_null($cekCode)) {
                    $updateItem[] = [
                        'Item_id'   => $cekCode->Item_id,
                        'quantity_good' => intval($cekCode->quantity_good) - intval($item['quantity']),
                        'qty_received' => intval($cekCode->qty_received) + intval($item['quantity']),

                    ];
                    if ($cekCode->quantity_good < $item['quantity']) {
                        $validate = false;
                        $htmlError .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5><i class="icon fas fa-times"></i> Gagal </h5>
                            Order ' . $item['Order_id'] . ' Gagal disimpan. Periksa stock anda
                            </div>';
                        break;
                    }
                } else {
                    $validate = false;
                    $htmlError .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5><i class="icon fas fa-times"></i> Gagal </h5>
                            Order ' . $item['Order_id'] . ' Gagal disimpan. Stock tidak ada
                            </div>';
                    break;
                }
            }
        }

        if ($validate) {
            $this->invoiceModel->uploadValidate($itemTemp, $updateItem, $orderNow2);
            // $pesan_success = [
            //     'success' => '<div class="alert alert-success alert-dismissible" role="alert">
            //                 <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
            //                 <h5><i class="icon fas fa-check"></i> Berhasil </h5>
            //                 Data Berhasil Di Import
            //                 </div>'
            // ];
            // session()->setFlashdata('error', $htmlError);
        }

        return $htmlError;
    }
    function detail()
    {
        if ($this->request->isAjax()) {
            $orderid = $this->request->getPost('order');

            $modelInvoice = new InvoiceModel();
            $ambilData = $modelInvoice->find($orderid);
            $data = [
                'isidata'        => $modelInvoice->getWhere(['Order_id' => $orderid]),
            ];
            $json = [
                'data'  => view('Stock/modalDetailOrder', $data)
            ];
            echo json_encode($json);
        }
    }
    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Order ID");
        $sheet->setCellValue('B1', "Item ID");
        $sheet->setCellValue('C1', "Item Detail");
        $sheet->setCellValue('D1', "Quantity");
        $sheet->setCellValue('E1', "Volume");
        $sheet->setCellValue('F1', "Vehicle Tag");
        $sheet->setCellValue('G1', "Drop Name");
        $sheet->setCellValue('H1', "Drop Contact");
        $sheet->setCellValue('I1', "Drop Address");
        $sheet->setCellValue('J1', "Drop City");
        $sheet->setCellValue('K1', "Drop Country");
        $sheet->setCellValue('L1', "Drop Zipcode");
        $sheet->setCellValue('M1', "Drop Latitude");
        $sheet->setCellValue('N1', "Drop Longitude");
        $sheet->setCellValue('O1', "Transaction Time (minutes)");
        $sheet->setCellValue('P1', "Drop Date");
        $sheet->setCellValue('Q1', "Drop Start Time");
        $sheet->setCellValue('R1', "Drop End Time");
        $sheet->setCellValue('S1', "Payment Method");
        $sheet->setCellValue('T1', "Amount");
        $sheet->setCellValue('U1', "Note");
        $sheet->setCellValue('V1', "Stock Location");

        $column = 2;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, '')
            ->setCellValue('B' . $column, '')
            ->setCellValue('C' . $column, '')
            ->setCellValue('D' . $column, '')
            ->setCellValue('E' . $column, '')
            ->setCellValue('F' . $column, '')
            ->setCellValue('G' . $column, '')
            ->setCellValue('H' . $column, '')
            ->setCellValue('I' . $column, '')
            ->setCellValue('J' . $column, '')
            ->setCellValue('K' . $column, '')
            ->setCellValue('L' . $column, '')
            ->setCellValue('M' . $column, '')
            ->setCellValue('N' . $column, '')
            ->setCellValue('O' . $column, '')
            ->setCellValue('P' . $column, '')
            ->setCellValue('Q' . $column, '')
            ->setCellValue('R' . $column, '')
            ->setCellValue('S' . $column, '')
            ->setCellValue('T' . $column, '')
            ->setCellValue('U' . $column, '')
            ->setCellValue('V' . $column, '');
        $column++;

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Tamplate Picking List';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
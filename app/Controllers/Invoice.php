<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelItem;
use App\Models\ModelOrder;

class Invoice extends BaseController
{
    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->ModalOrder   = new ModelOrder();
        $this->ModalItem    = new ModelItem();
    }
    public function index()
    {
        $warehouse = user()->warehouse;

        $data = [
            'data' => $this->invoiceModel->dataStatus(),
            'data' => $this->invoiceModel->dataStatusHo()
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

            foreach ($sheet as $x => $row) {
                if ($x == 0) {
                    continue;
                }
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


                $data = [
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
                    'created_at'        => isset($slot) == 1 ? $date = date('Y-m-d 08:15:00', strtotime('+1 days')) : $date = date('Y-m-d 14:15:00', strtotime('+1 days')),
                ];
                $this->invoiceModel->add($data);
                $data2 = [
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
                    'created_at'        =>
                    isset($slot) == 1 ? $date = date('Y-m-d 08:15:00', strtotime('+1 days')) : $date = date('Y-m-d 14:15:00', strtotime('+1 days')),
                ];
                $this->ModalOrder->add($data2);
                $pesan_success = [
                    'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil </h5>
                        Data Berhasil Di Import
                        </div>'
                ];
                session()->setFlashdata($pesan_success);
            }
            return redirect()->to('/Invoice/index');
        }
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
}

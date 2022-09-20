<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StockModel;

class Stock extends BaseController
{
    public function __construct()
    {
        $this->StockModel = new StockModel();
    }
    public function index()
    {
        $StatusModel = new StockModel();
        $warehouse = $this->request->getVar('warehouse');
        if ($warehouse == null) {
            $data = [
                'data'  => $StatusModel->findAll()
            ];
        } else {
            $data = [
                'data'  => $StatusModel->tampilDataTransaksi($warehouse)
            ];
        }

        return view('Stock/viewStock', $data);
    }
    public function upload()
    {
        $db = \Config\Database::connect();
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'fileimport' => [
                'label'     => 'Input Data Invoice',
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
            return redirect()->to('/Stock');
        } else {
            $file_upload = $this->request->getFile('fileimport');
            $date = $this->request->getPost('tglupload');
            $ext = $file_upload->getClientExtension();

            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file_upload);
            $sheet = $spreadsheet->getActiveSheet()->toArray();
            $dataGagal = [];
            foreach ($sheet as $x => $row) {
                if ($x == 0) {
                    continue;
                }
                $item_id                = $row[0];
                $item_detail            = $row[1];
                $qty                    = $row[2];
                $db = \Config\Database::connect();
                $cekCode = $db->table('tbl_stock')->getWhere(['Item_id' => $item_id])->getResult();

                if (count($cekCode) > 0) {
                    $dataGagal = count($cekCode);
                    $qtyStock = 0;
                    foreach ($cekCode as $row) {
                        $qtyStock += intval($row->quantity_good) + $qty;
                    }
                    for ($i = 0; $i < $dataGagal; $i++) {
                        $data2 = [
                            'quantity_good'  => intval($qtyStock),
                        ];
                        $this->StockModel->update($item_id, $data2);
                    }
                    $pesan_gagal = [
                        'error' => '<div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                            <h5><i class="icon fas fa-ban"></i> Data Sudah ada </h5>
                            Data Berhasil di update 
                            </div>'
                    ];
                    session()->setFlashdata($pesan_gagal);
                } else {

                    $data = [
                        'Item_id'           => $item_id,
                        'Item_detail'       => $item_detail,
                        'quantity_good'     => $qty,
                        'created_at'        => $date
                    ];
                    $this->StockModel->add($data);
                    $pesan_success = [
                        'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil </h5>
                        Data Berhasil Di Import
                        </div>'
                    ];
                    session()->setFlashdata($pesan_success);
                }
            }
            return redirect()->to('/Stock/index');
        }
    }
}
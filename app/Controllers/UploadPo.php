<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\PoModel;
use App\Models\UploadPoModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class UploadPo extends BaseController
{
    public function __construct()
    {
        $this->InboundModel = new InboundModel();
        $this->PoModel  = new PoModel();
    }
    public function index()
    {
        $statusPO = new UploadPoModel();
        $data = [
            'data'          => $statusPO->tampilDataTransaksi(),
            'nopo'          => $this->PoModel->buatPo()
        ];
        return view('stock/uploadPO', $data);
    }

    public function Upload()
    {
        $db = \Config\Database::connect();
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'fileimport' => [
                'label'     => 'Upload Data PO',
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
            return redirect()->to('/uploadPO');
        } else {
            $file_upload = $this->request->getFile('fileimport');
            $date = $this->request->getPost('tglupload');
            $nopo = $this->request->getPost('noPo');
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
                $item_id                = $row[0];
                $item_detail            = $row[1];
                $qty                    = $row[2];
                $warehouse              = $row[3];
                $db = \Config\Database::connect();
                $cekCode = $db->table('tbl_inbound')->getWhere(['Item_id' => $item_id])->getResult();

                $data = [
                    'nopo'          => $nopo,
                    'warehouse'     => $warehouse,
                    'Item_id'       => $item_id,
                    'Item_detail'   => $item_detail,
                    'quantity'      => $qty,
                    'created_at'    => $date,
                    'updated_at'    => $date,
                ];
                $this->InboundModel->add($data);
                $pesan_success = [
                    'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil </h5>
                        Data Berhasil Di Import
                        </div>'
                ];
                session()->setFlashdata($pesan_success);
            }
            $dataTem = $this->InboundModel->getWhere(['nopo' => $nopo]);
            $subtotal = 0;
            $countItem = $dataTem->getNumRows();
            foreach ($dataTem->getResultArray() as $row) :
                $subtotal += intval($row['quantity']);
            endforeach;
            $this->PoModel->add([
                'no_Po'         => $nopo,
                'jumlah_item'   => $countItem,
                'quantity_item' => $subtotal,
                'created_at'    => $date
            ]);
            return redirect()->to('/UploadPO/index');
        }
    }
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\PoModel;
use App\Models\UploadPoModel;
use CodeIgniter\HTTP\Files\UploadedFile;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        return view('Stock/uploadPO', $data);
    }

    public function Upload()
    {
        $nopo       = $this->request->getPost('noPo');
        $warehouse  = $this->request->getPost('warehouse');
        $estimate   = $this->request->getPost('estimate');
        $estimate   = date('Y-m-d', strtotime($estimate));
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
            // $date = $this->request->getPost('tglupload');
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
            $countRow = count($sheet);
            $htmlError = '';
            foreach ($sheet as $x => $row) {
                if ($x == 0) {
                    continue;
                }
                $item_id                = $row[0];
                $item_detail            = $row[1];
                $qty                    = $row[2];
                if (!is_int($qty)) {
                    $htmlError = [
                        'error' => '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-times"></i> Gagal </h5>
                        Quantity tidak valid
                        </div>'
                    ];
                    session()->setFlashdata($htmlError);
                    return redirect()->to('/UploadPo/index');
                } else {
                    $data = [
                        'nopo'          => $nopo,
                        'Item_id'       => $item_id,
                        'Item_detail'   => $item_detail,
                        'status'        => 0,
                        'estimate_date' => $estimate,
                        'quantity'      => $qty,
                        'warehouse'     => $warehouse,
                    ];
                    $this->InboundModel->add($data);
                    $htmlError = [
                        'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-check"></i> Sukses </h5>
                        Berhasil submit data
                        </div>'
                    ];
                }
            }
            $dataTem = $this->InboundModel->getWhere(['nopo' => $nopo]);
            $subtotal = 0;
            $countItem = $dataTem->getNumRows();
            foreach ($dataTem->getResultArray() as $row) :
                $subtotal += intval($row['quantity']);
            endforeach;
            $this->PoModel->insert([
                'no_Po'         => $nopo,
                'warehouse'     => $warehouse,
                'jumlah_item'   => $countItem,
                'quantity_item' => $subtotal,
                // 'created_at'    => $estimate
            ]);
            $htmlError = [
                'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-check"></i> Sukses </h5>
                        Berhasil submit data
                        </div>'
            ];

            session()->setFlashdata($htmlError);
            return redirect()->to('/UploadPo/index');
        }
    }

    // public function countStock($itemTemp, $orderNow, $nopo)
    // {
    //     $validate = true;
    //     $updateItem = [];
    //     $htmlError = '';
    //     $htmlSuccess = '';
    //     foreach ($itemTemp as $item) {
    //         if (!is_int($item['quantity'])) {
    //             $validate = false;
    //             $htmlError .= '<div class="alert alert-danger alert-dismissible" role="alert">
    //                     <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
    //                     <h5><i class="icon fas fa-check"></i> Gagal </h5>
    //                     Quantity tidak valid
    //                     </div>';
    //             break;
    //         }
    //     }

    //     if ($validate) {
    //         $this->InboundModel->insertBatch($itemTemp);

    //         foreach ($orderNow as $y) {
    //             $dataTem = $this->InboundModel->getWhere(['no_Po' => $nopo]);
    //             $subtotal = 0;
    //             $countItem = $dataTem->getNumRows();
    //             foreach ($dataTem->getResultArray() as $row) :
    //                 $subtotal += intval($row['quantity']);
    //             endforeach;
    //             $this->PoModel->insert([
    //                 'no_Po'         => $y['nopo'],
    //                 'warehouse'     => $y['warehouse'],
    //                 'jumlah_item'   => $countItem,
    //                 'quantity_item' => $subtotal,
    //                 // 'created_at'    => $estimate
    //             ]);
    //         }

    //         $validate = false;
    //         $htmlError .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    //                         <h5> <i class = "fa fa-check"></i></i> Berhasil </h5>
    //                         PO berhasil disimpan.
    //                         </div>';
    //     }
    //     return $htmlError;
    // }
    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Item Id");
        $sheet->setCellValue('B1', "Item Detail");
        $sheet->setCellValue('C1', "Quantity");

        $column = 2;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, '')
            ->setCellValue('B' . $column, '')
            ->setCellValue('C' . $column, '');
        $column++;

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Tamplate Input Inbound';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
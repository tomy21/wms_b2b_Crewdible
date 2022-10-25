<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\InvoiceModel;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiPacking extends ResourceController
{
    use ResponseTrait;

    public function index($warehouse = null)
    {
        $modelPacking   = new PackingModel();

        $cekOrder = $modelPacking->where(['warehouse' => $warehouse])->findAll();
        if (!$cekOrder) {
            $response = [
                "success"   => false,
                "data"      => 'Data not found',
            ];
            return $this->respond($response);
        } else {
            $response = [
                "success"   => true,
                "data"      => $cekOrder
            ];
            return $this->respond($response);
        }
    }
    public function detail($warehouse = null)
    {
        $modelPacking   = new PackingModel();
        $cekOrder = $modelPacking->where(['Status<' => 2, 'warehouse' => $warehouse])->findAll();
        if (!$cekOrder) {
            $response = [
                "success"   => false,
                "data"      => 'Data not found',
            ];
            return $this->respond($response);
        } else {
            $response = [
                "success"   => true,
                "data"      => $cekOrder
            ];
            return $this->respond($response);
        }
    }
    public function show($assign = null)
    {
        $modelPacking = new PackingModel();
        $id = $this->request->getPost('id');

        $Order = $modelPacking->getWhere(['order_id' => $id, 'Status<' => 2])->getResultArray();

        $respon = [
            'success'       => true,
            'data'          => $Order[0]
        ];

        return $this->respond(json_encode($respon), 200);
    }
    public function update($id = null)
    {
        // $rules = [
        //     'foto'  => 'uploaded[foto]|max_size[foto, 1024]|is_image[foto]'
        // ];

        // if ($this->validate($rules)) {
        //     return $this->fail($this->validator->getErrors());
        // } else {
        //     if ($file->isValid()) return $this->fail($this->validator->getErrors());
        $modelPacking   = new PackingModel();
        $modelInvoice   = new InvoiceModel();
        $modelOrder     = new ModelOrder();
        // $file = $this->request->getFile('foto');
        // $file->move('./assets/uploades');
        $file1 = $this->request->getFile('fotoAfter');
        $file1->move('./assets/uploades');

        $id = $this->request->getPost('id');
        $assign = $this->request->getPost('assign');

        $Order = $modelPacking->getWhere(['order_id' => $id])->getResultArray();

        if (!$Order) {
            $respon = [
                'success'       => true,
                'message'       => [
                    'error'     => 'data tidak ditemukan'
                ]
            ];

            return $this->fail('Quantity melebihi orderan');
        } else {
            $data = [
                'assign'    => $assign,
                'Status'    => 2,
                // 'foto'      => $file->getName(),
                'foto_after' => $file1->getName(),
            ];
            $modelPacking->update($id, $data);
            $modelOrder->update($id, ['status' => 5]);

            $orderInvoice = $modelInvoice->getWhere(['Order_id' => $id])->getRow();
            $modelInvoice->update($orderInvoice->id, ['status' => 5]);

            // $modelHandover = new HandoverModel();
            // foreach ($Order as $row) {
            //     if (count($Order) == 0) {
            //         $data = [
            //             'id_handover'  => $modelHandover->idHandover(),
            //             'listItem'  => $row['list'],
            //         ];
            //         $modelHandover->insert($data);
            //     } else {
            //         $data = [
            //             'id_handover'  => $modelHandover->idHandover(),
            //             'listItem'  => $row['list'],
            //         ];
            //         $modelHandover->insert($data);
            //     }
            // }
            $respon = [
                'success'       => true,
                'data'          => $data
            ];

            return $this->respond(json_encode($respon), 200);
        }
        // }
    }
    public function updateFoto($id = null)
    {
        // $rules = [
        //     'foto'  => 'uploaded[foto]|max_size[foto, 1024]|is_image[foto]'
        // ];

        // if ($this->validate($rules)) {
        //     return $this->fail($this->validator->getErrors());
        // } else {
        //     if ($file->isValid()) return $this->fail($this->validator->getErrors());
        $modelPacking   = new PackingModel();
        $file = $this->request->getFile('foto');
        $file->move('./assets/uploades');

        $id = $this->request->getPost('id');

        $Order = $modelPacking->getWhere(['order_id' => $id])->getResultArray();

        if (!$Order) {
            $respon = [
                'success'       => true,
                'message'       => [
                    'error'     => 'data tidak ditemukan'
                ]
            ];

            return $this->fail('' . $id . ' tidak ada');
        } else {
            $data = [
                'Status'    => 1,
                'foto'      => $file->getName(),
            ];
            $modelPacking->update($id, $data);

            $respon = [
                'success'       => true,
                'data'          => $data
            ];

            return $this->respond(json_encode($respon), 200);
        }
        // }
    }
}
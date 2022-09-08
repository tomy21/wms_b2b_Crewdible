<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\InvoiceModel;
use App\Models\ModelOrder;
use App\Models\PackingModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class ApiManifest extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $modelPacking = new HandoverModel();
        $order = $modelPacking->findAll();

        $data = [
            'success'   => true,
            'data'      => $order
        ];
        return $this->respond($data);
    }
    public function show($order = null)
    {
        $modelPacking = new PackingModel();
        $modelHandover = new HandoverModel();
        $modelInvoice = new InvoiceModel();
        $modelOrder   = new ModelOrder();
        $id = $this->request->getPost('id');

        $Order = $modelPacking->getWhere(['order_id' => $id])->getResult();
        foreach ($Order as $row) {
            $modelHandover->insert([
                'orderId'   => $id,
                'listItem'  => $row->list,
            ]);
        }
        $modelInvoice->update($id, ['status' => 6]);
        $modelOrder->update($id, ['status' => 6]);
        $respon = [
            'success'       => true,
        ];


        return $this->respond($respon, 200);
    }
    public function update($id = null)
    {

        $modelPacking = new HandoverModel();
        $modelInvoice = new InvoiceModel();
        $modelOrder   = new ModelOrder();
        $file = $this->request->getFile('foto');

        $file->move('./assets/uploades');

        $id = $this->request->getPost('id');
        $assign = $this->request->getPost('assign');

        $Order = $modelPacking->getWhere(['id' => $id])->getResultArray();

        if (!$Order) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $data = [
                'assign'    => $assign,
                'Status'    => 1,
                'foto'      => $file->getName(),
            ];
            $modelPacking->update($id, $data);
            $modelInvoice->update($id, ['status' => 7]);
            $modelOrder->update($id, ['status' => 7]);
            $modelHandover = new HandoverModel();
            foreach ($Order as $row) {
                $data = [
                    'Order_id'  => $row['Order_id'],
                    'listItem'  => $row['list'],
                ];
                $modelHandover->insert($data);
            }
            $respon = [
                'success'       => true,
                'data'          => $data
            ];

            return $this->respond(json_encode($respon), 200);
        }
        // }
    }
    public function add()
    {
        $list   = $this->request->getPost('list');
        $driver = $this->request->getPost('driver');
        $foto   = $this->request->getFile('foto');
        $foto->move('./assets/uploades');
        $ttd    = $this->request->getFile('ttd');
        $ttd->move('./assets/uploades');

        $modelHandover = new HandoverModel();

        // $Order = $modelHandover->getWhere(['Order_id' => $order])->getResultArray();

        $data = [
            'listItem'          => $list,
            'driver'            => $driver,
            'foto'              => $foto->getName(),
            'tandatangan'       => $ttd->getName(),
        ];
        $modelHandover->insert($data);

        $respon = [
            'success'       => true,
            'data'          => $data
        ];

        return $this->respond(json_encode($respon), 200);
    }
}
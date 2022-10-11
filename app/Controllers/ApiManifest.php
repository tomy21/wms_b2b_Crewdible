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
        $order = $modelPacking->getWhere(['status' => 0])->getResult();

        $data = [
            'success'   => true,
            'data'      => $order
        ];
        return $this->respond($data);
    }
    public function show($assign = null)
    {
        $modelPacking = new HandoverModel();
        $id = $this->request->getPost('id');

        $Order = $modelPacking->getWhere(['id_handover' => $id, 'status' => 0])->getResultArray();

        $respon = [
            'success'       => true,
            'data'          => $Order[0]
        ];

        return $this->respond(json_encode($respon), 200);
    }
    public function update($id = null)
    {

        $modelPacking = new HandoverModel();
        $modelInvoice = new InvoiceModel();
        $modelOrder   = new ModelOrder();
        $file = $this->request->getFile('foto');
        $file->move('./assets/uploades');
        $ttd = $this->request->getPost('tandatangan');
        $ttd->move('./assets/uploades');
        $id = $this->request->getPost('id');
        $assign = $this->request->getPost('assign');
        $warehouse = $this->request->getPost('warehouse');

        $Order = $modelPacking->getWhere(['id_handover' => $id])->getResultArray();

        if (!$Order) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $data = [
                'assign'            => $assign,
                'status'            => 1,
                'foto'              => $file->getName(),
                'tandatangan'       => $file->getName(),
                'warehouse'         => $warehouse,
            ];
            $modelPacking->update($id, $data);
            foreach ($Order as $row) {
                $item = json_decode($row['listItem']);
                $list = (array)$item;
                $count = count($item);
                for ($i = 0; $i < $count; $i++) {
                    $orderID = $item[$i]->order_id;

                    $getId = $modelInvoice->getWhere(['Order_id' => $orderID])->getResult();
                    foreach ($getId as $data) {
                        $modelInvoice->update($data->id, ['status' => 7]);
                    }

                    $modelOrder->update($orderID, ['status' => 7]);
                }
            }

            // $modelHandover = new HandoverModel();

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
        $modelHandover = new HandoverModel();
        $idHandover = $modelHandover->idHandover();
        $list   = $this->request->getPost('list');
        $driver = $this->request->getPost('driver');
        $warehouse = $this->request->getPost('warehouse');


        // $Order = $modelHandover->getWhere(['Order_id' => $order])->getResultArray();

        $data = [
            'id_handover'       => $idHandover,
            'listItem'          => $list,
            'driver'            => $driver,
            'warehouse'         => $warehouse
        ];
        $modelHandover->insert($data);

        $respon = [
            'success'       => true,
            'data'          => $data
        ];

        return $this->respond(json_encode($respon), 200);
    }
}
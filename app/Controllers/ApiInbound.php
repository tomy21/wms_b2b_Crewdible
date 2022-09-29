<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\PoModel;
use CodeIgniter\API\ResponseTrait;

class ApiInbound extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $modelInbound = new PoModel();
        $data = $modelInbound->findAll();

        if (!$data) {
            return $this->failNotFound('Tidak ada inbound');
        } else {
            $respon = [
                'success'   => true,
                'data'      => $data,
            ];

            return $this->respond($respon, 200);
        }
    }

    public function getId($id = null)
    {
        $model = new InboundModel();
        $id     = $this->request->getVar('id');
        $data1 = $model->getWhere(['nopo' => $id])->getResult();
        foreach ($data1 as $row) {
            $dataJson[] = [
                'id'        => $row->id,
                'itemId'    => $row->Item_id,
                'itemDetail' => $row->Item_detail,
                'qty'       => $row->quantity,
                'statusItem'    => $row->status,
            ];
        }
        if ($data1) {
            $response = [
                "success"   => true,
                "data"      => [
                    'nopo'      => $id,
                    'warehouse'    => $row->warehouse,
                    'status'    => $row->status,
                    'listItem'  => json_encode($dataJson)

                ],
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    public function show($warehouse = null)
    {
        $modelInbound = new PoModel();

        $data = $modelInbound->getWhere(['warehouse' => $warehouse])->getResult();

        if (!$data) {
            return $this->failNotFound('Tidak ada inbound');
        } else {
            $respon = [
                'success'   => true,
                'data'      => $data,
            ];

            return $this->respond($respon, 200);
        }
    }
    public function update($id = null)
    {
        $model = new InboundModel();

        $id             = $this->request->getVar('id');
        $qtyCount       = $this->request->getVar('quantity');

        $cekData = $model->getWhere(['id' => $id])->getResult();

        if (!$cekData) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            foreach ($cekData as $row) {
                if ($row->status == 1) {
                    return $this->failNotFound('Data sudah diterima');
                } else {
                    if ($row->quantity < $qtyCount) {
                        return $this->failNotFound('Quantity lebih');
                    } else {
                        $data = [
                            'qty_received'  => $qtyCount,
                            'status'        => 1,
                        ];
                        $model->update($id, $data);
                        $response = [
                            'status'   => 200,
                            'success'  => true,
                            'messages' => [
                                'success' => 'Data Updated'
                            ]
                        ];
                    }
                }
            }
        }
        return $this->respond($response);
    }
    public function updatePo($po = null)
    {
        $modelInbound = new PoModel();

        $po = $this->request->getPost('nopo');
        $noplat = $this->request->getPost('noplat');
        $driver = $this->request->getPost('driver');
        $qty = $this->request->getPost('quantity_count');
        $date = $this->request->getPost('date');
        $date = date('Y-m-d', strtotime($date));
        $foto = $this->request->getFile('foto');
        $foto->move('./assets/inbound');
        $ttd = $this->request->getFile('tandatangan');
        $ttd->move('./assets/inbound');

        $data = $modelInbound->getWhere(['no_Po' => $po])->getResult();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $data = [
                'driver'                => $driver,
                'noplat'                => $noplat,
                'foto'                  => $foto->getName(),
                'tandatangan'           => $ttd->getName(),
                'quantity_count'        => $qty,
                'waktu_datang'          => $date,
                'status'                => 1
            ];
            $modelInbound->update($po, $data);
            $respon = [
                'success'       => true,
                'data'          => $data
            ];

            return $this->respond($respon, 200);
        }
    }
}
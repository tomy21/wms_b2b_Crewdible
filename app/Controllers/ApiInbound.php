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
        $modelPo = new PoModel();
        $id     = $this->request->getVar('id');
        $data2  = $modelPo->getWhere(['no_Po' => $id, 'status' => 0])->getResult();
        $data1 = $model->getWhere(['nopo' => $id, 'status' => 0])->getResult();
        foreach ($data1 as $row) {
            $dataJson[] = [
                'id'        => $row->id,
                'itemId'    => $row->Item_id,
                'itemDetail' => $row->Item_detail,
                'qty'       => $row->quantity,
                'statusItem'    => $row->status,
            ];
            foreach ($data2 as $value) {
                $data = [
                    'quantityCount' => $value->quantity_count,
                ];
            }
            if ($data1) {

                $response = [
                    "success"   => true,
                    "data"      => [
                        'nopo'      => $id,
                        'warehouse'    => $row->warehouse,
                        'status'    => $row->status,
                        'qty'       => $data['quantityCount'],
                        'listItem'  => json_encode($dataJson)

                    ],
                ];
                return $this->respond($response);
            } else {
                return $this->failNotFound('No Data Found with id ' . $id);
            }
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
            $qty = [];
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
                        $modelPo = new PoModel();
                        $cekItem = $model->select('sum(qty_received) as qtyRec')->getWhere(['nopo' => $row->nopo])->getRow();
                        $cekSelisih = $modelPo->getWhere(['no_Po' => $row->nopo])->getRow();


                        $y = [
                            'quantity_count' => $cekItem->qtyRec,
                            'selisih'        => intval($cekSelisih->quantity_item) - intval($cekItem->qtyRec)
                        ];
                        $modelPo->update($row->nopo, $y);

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
        $date = $this->request->getPost('date');
        $date = date('Y-m-d', strtotime($date));
        $foto = $this->request->getFile('foto1');
        $foto->move('./assets/inbound');
        $foto2 = $this->request->getFile('foto2');
        $foto2->move('./assets/inbound');

        $data = $modelInbound->getWhere(['no_Po' => $po])->getResult();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $data = [
                'driver'                => $driver,
                'noplat'                => $noplat,
                'foto'                  => $foto->getName(),
                'tandatangan'           => $foto2->getName(),
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
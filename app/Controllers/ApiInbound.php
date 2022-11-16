<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundModel;
use App\Models\PoModel;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use Config\Services;

class ApiInbound extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $request = Services::request();
        $modelInbound = new PoModel($request);
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
        $request = Services::request();
        $model = new InboundModel();
        $modelPo = new PoModel($request);
        $id     = $this->request->getVar('id');
        $data2  = $modelPo->getWhere(['no_Po' => $id])->getResult();
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
                    'qty'       => $data['quantityCount'],
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
        $request = Services::request();
        $modelInbound = new PoModel($request);

        $data = $modelInbound->getWhere(['warehouse' => $warehouse, 'status' => "0"])->getResult();

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
        $status         = $this->request->getVar('status');

        $cekData = $model->getWhere(['id' => $id])->getResult();

        if (!$cekData) {
            $response = [
                'status'   => 500,
                'error'    => true,
                'messages' => [
                    'error' => 'Tidak ada Inbound'
                ]
            ];
            return $this->fail('Tidak ada Inbound');
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
                            'status'        => $status,
                        ];
                        $model->update($id, $data);
                        $request = Services::request();
                        $modelPo = new PoModel($request);
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
        $request = Services::request();
        $modelInbound = new PoModel($request);

        $po = $this->request->getPost('nopo');
        $noplat = $this->request->getPost('noplat');
        $driver = $this->request->getPost('driver');
        $date = $this->request->getPost('date');
        // $date = date('Y-m-d H:mm:dd', strtotime($date));
        $foto = $this->request->getFile('foto1');
        $foto2 = $this->request->getFile('foto2');

        $data = $modelInbound->getWhere(['no_Po' => $po])->getResult();

        $bucketName = 'crewdible-sandbox-asset';
        $keyID      = 'AKIAUDN4SHKM45YIKVNS';
        $keyScret   = 'Ne+n1vBDXP+DnAzZAAzqD3wh0KN7Jq2Snsk7KiW1';

        $validationRule = [
            'foto1' => [
                'label' => 'Image File',
                'rules' => 'uploaded[foto1]'
                    . '|is_image[foto1]'
                    . '|mime_in[foto1,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[foto1,1000]'
                    . '|max_dims[foto1,1024,768]',
            ],
            'foto2' => [
                'label' => 'Image File',
                'rules' => 'uploaded[foto2]'
                    . '|is_image[foto2]'
                    . '|mime_in[foto2,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[foto2,1000]'
                    . '|max_dims[foto2,1024,768]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            $respon = [
                'success'       => true,
                'message'       => [
                    'error'     => 'data tidak ditemukan'
                ]
            ];

            return $this->fail('' . $po . ' tidak ada');
        }

        if (!$foto->hasMoved() && !$foto2->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $foto->store();
            $filepath1 = WRITEPATH . 'uploads/' . $foto2->store();

            $data = ['uploaded_flleinfo' => new File($filepath)];

            // Inisiasi helper S3
            $s3Client = new S3Client([
                'version' => 'latest',
                'region' => 'ap-southeast-1',
                'url' => 'https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com' . $bucketName . '/',
                'use_path_style_endpoint' => true,
                'endpoint' => 'https://s3.ap-southeast-1.amazonaws.com',
                'credentials' => [
                    'key' => $keyID,
                    'secret' => $keyScret
                ]
            ]);


            $key = basename($filepath);
            $key1 = basename($filepath1);

            try {
                // Proses upload ke object storage dengan permission file public
                $result = $s3Client->upload($bucketName, 'aws-b2b/' . $key . '', fopen($filepath, 'r'), 'public-read');
                $result = $s3Client->upload($bucketName, 'aws-b2b/' . $key1 . '', fopen($filepath1, 'r'), 'public-read');
                $data = ['result' => $result->toArray()];
            } catch (S3Exception $e) {
                $data = ['errors' => $e->getMessage()];
            }
        }

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $data = [
                'driver'                => $driver,
                'noplat'                => $noplat,
                'foto'                  => $foto->getName(),
                'tandatangan'           => $foto2->getName(),
                'waktu_datang'          => $date,
                'status'                => 1,
                'created_at'            => date("Y-m-d H:i:s")
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
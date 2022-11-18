<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\InvoiceModel;
use App\Models\ModelListHandover;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use Config\Services;

class ApiManifest extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $request = Services::request();
        $modelPacking = new HandoverModel($request);
        $order = $modelPacking->getWhere(['status' => 0])->getResult();

        if (!$order) {
            $response = [
                "success"   => false,
                "data"      => 'Data not found',
            ];
            return $this->respond($response);
        } else {
            $response = [
                "success"   => true,
                "data"      => $order
            ];
            return $this->respond($response);
        }
    }
    public function detail($warehouse = null)
    {
        $request = Services::request();
        $modelManifest = new HandoverModel($request);
        $order = $modelManifest->getWhere(['status' => 0, 'warehouse' => $warehouse])->getResult();

        if (!$order) {
            $response = [
                "success"   => false,
                "data"      => 'Data not found',
            ];
            return $this->respond($response);
        } else {
            $response = [
                "success"   => true,
                "data"      => $order
            ];
            return $this->respond($response);
        }
    }
    public function show($assign = null)
    {
        $request = Services::request();
        $modelPacking = new HandoverModel($request);
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
        $request = Services::request();
        $modelPacking = new HandoverModel($request);
        $modelInvoice = new InvoiceModel();
        $modelOrder   = new ModelOrder($request);
        $id = $this->request->getPost('id');
        $assign = $this->request->getPost('assign');
        $warehouse = $this->request->getPost('warehouse');
        $file = $this->request->getFile('foto');
        $ttd = $this->request->getFile('tandatangan');

        $Order = $modelPacking->getWhere(['id_handover' => $id])->getResultArray();
        $bucketName = 'crewdible-sandbox-asset';
        $keyID      = 'AKIAUDN4SHKM45YIKVNS';
        $keyScret   = 'Ne+n1vBDXP+DnAzZAAzqD3wh0KN7Jq2Snsk7KiW1';

        $validationRule = [
            'foto' => [
                'label' => 'Image File',
                'rules' => 'uploaded[foto]'
                    . '|is_image[foto]'
                    . '|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[foto,1000]'
                    . '|max_dims[foto,1024,768]',
            ],
            'tandatangan' => [
                'label' => 'Image File',
                'rules' => 'uploaded[tandatangan]'
                    . '|is_image[tandatangan]'
                    . '|mime_in[tandatangan,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[tandatangan,1000]'
                    . '|max_dims[tandatangan,1024,768]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            $respon = [
                'success'       => true,
                'message'       => [
                    'error'     => 'data tidak ditemukan'
                ]
            ];

            return $this->fail('' . $id . ' tidak ada');
        }

        if (!$file->hasMoved() && !$ttd->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $file->store();
            $filepath1 = WRITEPATH . 'uploads/' . $ttd->store();

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
                $result = [
                    'result1'   => $s3Client->upload($bucketName, 'aws-b2b/' . $key . '', fopen($filepath, 'r'), 'public-read'),
                    'result2'   => $s3Client->upload($bucketName, 'aws-b2b/' . $key1 . '', fopen($filepath1, 'r'), 'public-read'),
                ];
                // $result = $s3Client->upload($bucketName, $key, fopen($filepath, 'r'), 'public-read');
                // $result = $s3Client->upload($bucketName, $key1, fopen($filepath1, 'r'), 'public-read');
                $data = ['result' => $result];
            } catch (S3Exception $e) {
                $data = ['errors' => $e->getMessage()];
            }
        }

        if (!$Order) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $data = [
                'assign'            => $assign,
                'status'            => 1,
                'foto'              => $file->getName(),
                'tandatangan'       => $ttd->getName(),
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
                        $modelInvoice->update($data->id, ['status' => 6]);
                    }

                    $modelOrder->update($orderID, ['status' => 6]);
                }
            }
            $modelListHandover = new ModelListHandover();
            $getListHandover = $modelListHandover->getWhere(['id_handover' => $id])->getResult();
            foreach ($getListHandover as $p) {
                $modelListHandover->update($p->id, ['status' => 2]);
            }

            $request = Services::request();
            $modelHandover = new HandoverModel($request);

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
        $request = Services::request();
        $modelHandover = new HandoverModel($request);
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
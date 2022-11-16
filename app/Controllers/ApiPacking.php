<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\InvoiceModel;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use App\Controllers\Exception;
use CodeIgniter\Files\File;
use Config\Services;

class ApiPacking extends ResourceController
{
    use ResponseTrait;

    public function index($warehouse = null)
    {
        $request = Services::request();
        $modelPacking   = new PackingModel($request);

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
        $request = Services::request();
        $modelPacking   = new PackingModel($request);
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
        $request = Services::request();
        $modelPacking = new PackingModel($request);
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
        $request = Services::request();
        $modelPacking   = new PackingModel($request);
        $modelInvoice   = new InvoiceModel();
        $modelOrder     = new ModelOrder($request);
        $file1 = $this->request->getFile('fotoAfter');
        $id = $this->request->getPost('id');
        $assign = $this->request->getPost('assign');
        $Order = $modelPacking->getWhere(['order_id' => $id])->getResultArray();
        $bucketName = 'crewdible-sandbox-asset';
        $keyID      = 'AKIAUDN4SHKM45YIKVNS';
        $keyScret   = 'Ne+n1vBDXP+DnAzZAAzqD3wh0KN7Jq2Snsk7KiW1';

        $validationRule = [
            'fotoAfter' => [
                'label' => 'Image File',
                'rules' => 'uploaded[fotoAfter]'
                    . '|is_image[fotoAfter]'
                    . '|mime_in[fotoAfter,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[fotoAfter,1000]'
                    . '|max_dims[fotoAfter,1024,768]',
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

        if (!$file1->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $file1->store();

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

            try {
                // Proses upload ke object storage dengan permission file public
                $result = $s3Client->upload($bucketName, 'aws-b2b/' . $key . '', fopen($filepath, 'r'), 'public-read');
                $data = ['result' => $result->toArray()];
            } catch (S3Exception $e) {
                $data = ['errors' => $e->getMessage()];
            }
        }


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
                'foto_after' => $file1->getName(),
            ];
            $modelPacking->update($id, $data);
            $modelOrder->update($id, ['status' => 5]);

            $orderInvoice = $modelInvoice->getWhere(['Order_id' => $id])->getRow();
            $modelInvoice->update($orderInvoice->id, ['status' => 4]);

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
                'url'           => ['result' => $result->toArray()],
                'data'          => $data
            ];

            return $this->respond(json_encode($respon), 200);
        }
        // }
    }
    public function updateFoto($id = null)
    {
        $request = Services::request();
        $modelPacking   = new PackingModel($request);
        $modelInvoice   = new InvoiceModel();
        $modelOrder     = new ModelOrder($request);
        $file1 = $this->request->getFile('foto');
        $id = $this->request->getPost('id');
        $Order = $modelPacking->getWhere(['order_id' => $id])->getResultArray();
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

        if (!$file1->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $file1->store();

            $data = ['uploaded_flleinfo' => new File($filepath)];

            // Inisiasi helper S3
            $s3Client = new S3Client([
                'version' => 'latest',
                'region' => 'ap-southeast-1',
                'url' => 'https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/' . $bucketName . '/',
                'use_path_style_endpoint' => true,
                'endpoint' => 'https://s3.ap-southeast-1.amazonaws.com',
                'credentials' => [
                    'key' => $keyID,
                    'secret' => $keyScret
                ]
            ]);


            $key = basename($filepath);

            try {
                // Proses upload ke object storage dengan permission file public
                $result = $s3Client->upload($bucketName, 'aws-b2b/' . $key . '', fopen($filepath, 'r'), 'public-read');
                $data = ['result' => $result->toArray()];
            } catch (S3Exception $e) {
                $data = ['errors' => $e->getMessage()];
            }
        }


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
                'Status'    => 1,
                'foto' => $file1->getName(),
            ];
            $modelPacking->update($id, $data);
            $modelOrder->update($id, ['status' => 4]);

            $orderInvoice = $modelInvoice->getWhere(['Order_id' => $id])->getRow();
            $modelInvoice->update($orderInvoice->id, ['status' => 4]);

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
                'url'           => ['result' => $result->toArray()],
                'data'          => $data
            ];

            return $this->respond(json_encode($respon), 200);
        }
        // }
    }
}
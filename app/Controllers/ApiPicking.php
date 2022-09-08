<?php

namespace App\Controllers;

use App\Models\PickingModel;
use App\Models\StockModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiPicking extends ResourceController
{
    use ResponseTrait;
    // get all product
    public function index()
    {
        $model = new PickingModel();
        $data = $model->where('status', 0)->groupBy('id_basket')->findAll();
        $response = [
            "success"   => true,
            "data"      => $data
        ];
        return $this->respond($response);
    }

    // get single product
    public function show($assign = null)
    {
        $model = new PickingModel();
        $data = $model->where('assign', $assign)->groupBy('id_basket')->findAll();
        if ($data) {
            $response = [
                "success"   => true,
                "data"      => $data
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $assign);
        }
    }
    public function getId($id = null)
    {
        $model = new PickingModel();
        $id     = $this->request->getVar('id');
        $data = $model->where('status', 0)->find($id);
        $data1 = $model->getWhere(['status' => 0, 'id_basket' => $id])->getResult();
        foreach ($data1 as $row) {
            $dataJson[] = [
                'id'        => $row->id,
                'itemId'    => $row->Item_id,
                'itemDetail' => $row->Item_detail,
                'qty'       => $row->qty,
            ];
        }
        if ($data1) {
            $response = [
                "success"   => true,
                "data"      => [
                    'id_basket' => $id,
                    'assign'    => $row->assign,
                    'status'    => $row->status,
                    'listItem'  => json_encode($dataJson)

                ],
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }


    // create a product
    // public function create()
    // {
    //     $model = new PickingModel();
    //     $data = [
    //         'product_name' => $this->request->getPost('product_name'),
    //         'product_price' => $this->request->getPost('product_price')
    //     ];
    //     $data = json_decode(file_get_contents("php://input"));
    //     //$data = $this->request->getPost();
    //     $model->insert($data);
    //     $response = [
    //         'status'   => 201,
    //         'error'    => null,
    //         'messages' => [
    //             'success' => 'Data Saved'
    //         ]
    //     ];

    //     return $this->respondCreated($data, 201);
    // }

    // update product
    public function update($id = null)
    {
        $model = new PickingModel();
        $modelStock = new StockModel();

        $id             = $this->request->getVar('id');
        $qtyCount       = $this->request->getVar('quantity');

        $cekData = $model->getWhere(['id' => $id])->getResult();

        if (!$cekData) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            foreach ($cekData as $row) {
                $qty = intval($row->quantity_pick) + intval($qtyCount);
                if ($row->qty != $qty) {
                    $qty = intval($row->quantity_pick) + intval($qtyCount);
                    $data = [
                        'quantity_pick' => $qty,
                        'status'        => 0,
                    ];
                    if ($row->qty < $qty) {
                        $response = [
                            'status'   => 500,
                            'error'    => true,
                            'messages' => [
                                'error' => 'Quantity melebihi orderan'
                            ]
                        ];
                    } else {
                        $modelStock = new StockModel();
                        $getStock = $modelStock->getWhere(['Item_id'  => $row->Item_id])->getResult();
                        foreach ($getStock as $query) {
                            if ($query['quantity_good'] < $qtyCount) {
                                $response = [
                                    'status'   => 500,
                                    'error'    => true,
                                    'messages' => [
                                        'error' => 'Stock Kurang'
                                    ]
                                ];
                            } else {
                                $itemId = $modelStock->getWhere(['Item_id' => $row->Item_id])->getResult();

                                $qtyStock = 0;
                                foreach ($itemId as $x) {
                                    $qtyStock = intval($x->quantity_good) - intval($qtyCount);
                                    $dataStock = [
                                        'quantity_good' => $qtyStock
                                    ];
                                    $modelStock->update($x->Item_id, $dataStock);
                                }
                                // Insert to Database


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
                } else {
                    $qty = intval($row->quantity_pick) + intval($qtyCount);
                    $data = [
                        'quantity_pick' => $qty,
                        'status'        => 1,
                    ];
                    if ($row->qty < $qty) {
                        $response = [
                            'status'   => 500,
                            'error'    => true,
                            'messages' => [
                                'error' => 'Quantity melebihi orderan'
                            ]
                        ];
                    } else {
                        $itemId = $modelStock->getWhere(['Item_id' => $row->Item_id])->getResult();

                        $qtyStock = 0;
                        foreach ($itemId as $y) {
                            $qtyStock = intval($y->quantity_good) - intval($qtyCount);
                            $dataStock = [
                                'quantity_good' => $qtyStock
                            ];
                            $modelStock->update($y->Item_id, $dataStock);
                        }
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

    // delete product
    // public function delete($id = null)
    // {
    //     $model = new PickingModel();
    //     $data = $model->find($id);
    //     if ($data) {
    //         $model->delete($id);
    //         $response = [
    //             'status'   => 200,
    //             'error'    => null,
    //             'messages' => [
    //                 'success' => 'Data Deleted'
    //             ]
    //         ];

    //         return $this->respondDeleted($response);
    //     } else {
    //         return $this->failNotFound('No Data Found with id ' . $id);
    //     }
    // }
}

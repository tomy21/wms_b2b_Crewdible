<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelOrder;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiOrder extends ResourceController
{
    use ResponseTrait;
    public function show($order = null)
    {
        $modelInvoice = new InvoiceModel();
        $id = $this->request->getPost('order');

        $Order = $modelInvoice->getWhere(['Order_id' => $id])->getResultArray();
        $listItem =
            $modelInvoice->where('Order_id', $id)->select('id,Item_id,Item_detail,quantity')->get()->getResultArray();
        if (!$Order) {

            return $this->failNotFound('Data tidak ditemukan');
        } else {
            $respon = [
                'success'       => true,
                'data'          => [
                    'orderId'   => $id,
                    'list'      => $listItem
                ]
            ];

            return $this->respond($respon, 200);
        }
    }
}
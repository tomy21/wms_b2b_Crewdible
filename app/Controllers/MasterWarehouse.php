<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWarehouse;

class MasterWarehouse extends BaseController
{
    public function index()
    {
        $modalWarehouse = new ModelWarehouse();

        return view('master_warehouse/masterwarehouse', ['data' => $modalWarehouse->findAll()]);
    }

    public function modalTambah()
    {
        if ($this->request->isAJAX()) {
            $modalWarehouse = new ModelWarehouse();
            $data = $modalWarehouse->idWarehosue();
            $json = [
                'data' => view('master_warehouse/modalTambah', ['id' => $data]),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function addWarehouse()
    {
        if ($this->request->isAJAX()) {
            $idbasket = $this->request->getPost('id');
            $warehouse = $this->request->getPost('warehouse');
            $modalWarehouse = new ModelWarehouse();

            $modalWarehouse->insert([
                'id_warehouse'     => $idbasket,
                'warehouse_name'     => $warehouse,
            ]);

            $json = [
                'success'       => 'Basket berhasil ditambah'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function updateData()
    {
        if ($this->request->isAJAX()) {
            $modalWarehouse = new ModelWarehouse();
            $id     = $this->request->getPost('code');
            $data = $modalWarehouse->find($id);
            $json = [
                'data' => view('master_warehouse/updateWarehouse', ['id' => $data['id_warehouse'], 'warehouse' => $data['warehouse_name'],'code'=>$data['warehouse_code']]),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $modalWarehouse = new ModelWarehouse();
            $id     = $this->request->getPost('id');
            $name   = $this->request->getPost('warehouse');
            $code   = $this->request->getPost('code');
            $modalWarehouse->update($id, ['warehouse_name' => $name,'warehouse_code'=>$code]);
            $json = [
                'success' => "$id Berhasil di update"
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
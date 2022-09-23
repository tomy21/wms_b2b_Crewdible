<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
    public function update($po = null)
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
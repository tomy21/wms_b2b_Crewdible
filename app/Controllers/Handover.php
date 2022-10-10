<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\ModelListHandover;
use App\Models\ModelOrder;

use function PHPUnit\Framework\isNull;

class Handover extends BaseController
{
    public function index()
    {
        $modelHandover = new HandoverModel();

        return view('Handover/index', ['data' => $modelHandover->findAll()]);
    }
    public function buatManifest()
    {

        $modalHandover = new HandoverModel();
        $modalList      = new ModelListHandover();
        $data = [
            'idHandover'    => $modalHandover->idHandover(),
            'query'         => $modalList->getWhere(['status' => 0])->getResult(),
        ];

        return view('Handover/buat_manifest', $data);
    }
    function simpanTemResi()
    {
        $order = $this->request->getVar('order');
        $driver = $this->request->getVar('driver');
        $id = $this->request->getVar('idHandover');

        $modelOrder = new ModelOrder();
        $cekOrder = $modelOrder->getWhere(['Order_id' => $order])->getRow();
        $cekOrder1 = $modelOrder->getWhere(['Order_id' => $order])->getResult();

        $modelListHandover = new ModelListHandover();
        $cekList = $modelListHandover->getWhere(['order_id' => $order, 'id_handover' => $id])->getResult();

        if (count($cekOrder1) == 0) {

            $json = [
                'error' => 'Order tidak ada, periksa kembali..!'
            ];
        } else {
            if ($cekList != null) {
                $json = [
                    'error' => 'Orderan ini sudah ada...!'
                ];
            } else {
                $data = [
                    'order_id'      => $order,
                    'nama_penerima' => $cekOrder->Drop_name,
                    'alamat'        => $cekOrder->Drop_address,
                    'no_tlp'        => $cekOrder->Drop_contact,
                    'status'        => 0,
                    'driver'        => $driver,
                    'id_handover'   => $id
                ];
                $modelListHandover->insert($data);

                $modelOrder->update($order, ['driver' => $driver]);
                $json = [
                    'sukses'    => 'Data berhasil di update'
                ];
            }
        }
        echo json_encode($json);
    }
    function simpanData()
    {
        $id = $this->request->getVar('id');

        $modelListHandover = new ModelListHandover();
        $cek = $modelListHandover->getWhere(['id_handover' => $id])->getRow();
        $cek2 = $modelListHandover->getWhere(['id_handover' => $id])->getResult();

        foreach ($cek2 as $q) {
            $datajson[] = [
                'id'        => $q->id,
                'id_handover'   => $q->id_handover,
                'order_id'  => $q->order_id,
                'nama_penerima' => $q->nama_penerima,
                'alamat'        => $q->alamat,
                'no_tlp'        => $q->no_tlp,
            ];
            $modelListHandover->update($q->id, ['status' => 1]);
        }
        $modelHandover = new HandoverModel();
        $cekId = $modelHandover->getWhere(['id_handover' => $id])->getResult();
        if (count($cekId) > 0) {
            $json = [
                'error' => "$id sudah ada",
            ];
        } else {
            $query = [
                'id_handover'       => $id,
                'listItem'          => json_encode($datajson),
                'driver'            => $cek->driver,
            ];
            $modelHandover->insert($query);



            $json = [
                'sukses'    => 'Berhasil membuat manifest',
            ];
        }
        echo json_encode($json);
    }
}
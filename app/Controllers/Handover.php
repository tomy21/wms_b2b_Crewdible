<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\InvoiceModel;
use App\Models\ModelListHandover;
use App\Models\ModelOrder;
use App\Models\PackingModel;

use function PHPUnit\Framework\isNull;

class Handover extends BaseController
{
    public function index()
    {
        $modelHandover = new ModelListHandover();

        return view('Handover/index');
    }
    public function buatManifest()
    {

        $modalHandover = new HandoverModel();
        $modalList      = new ModelListHandover();
        $data = [
            'idHandover'    => $modalHandover->idHandover(),
            // 'query'         => $modalList->getWhere(['status' => 0])->getResult(),
        ];

        return view('Handover/buat_manifest', $data);
    }
    public function Manifest_Temp()
    {
        if ($this->request->isAJAX()) {
            $driver = $this->request->getPost('driver');
            $modelTemp = new ModelListHandover();


            $data = [
                'datatemp'      => $modelTemp->getWhere(['status' => 0])->getResult(),
            ];
            $json = [
                'data' => view('Handover/dataTemp', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function simpanTemResi()
    {
        $order = $this->request->getVar('order');
        $warehouse = $this->request->getVar('warehouse');
        $id = $this->request->getVar('idHandover');

        $modelOrder = new ModelOrder();
        $cekOrder = $modelOrder->getWhere(['Order_id' => $order, 'status' => 5])->getRow();
        $cekOrder1 = $modelOrder->getWhere(['Order_id' => $order, 'status' => 5])->getResult();

        $modelListHandover = new ModelListHandover();
        $cekList = $modelListHandover->getWhere(['order_id' => $order])->getResult();

        if (count($cekOrder1) == 0) {
            $json = [
                'error' => 'Order tidak ada, periksa kembali..!'
            ];
        } else {
            if (count($cekList) == 1) {
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
                    'warehouse'     => $warehouse,
                    'id_handover'   => $id
                ];
                $modelListHandover->insert($data);

                $modelPacking   = new PackingModel();
                $getId          = $modelPacking->getWhere(['order_id' => $order])->getRow();
                $modelPacking->update($getId->id, ['Status' => 3]);

                // $modelOrder->update($order, ['driver' => $driver]);
                $json = [
                    'sukses' => 'item berhasil ditambah'
                ];
            }
        }
        echo json_encode($json);
    }
    function simpanData()
    {
        $id = $this->request->getVar('id');
        $driver = $this->request->getVar('driver');
        $warehouse = $this->request->getVar('warehouse');

        $modelOrder     = new ModelOrder();
        $modelListHandover = new ModelListHandover();
        $cek = $modelListHandover->getWhere(['id_handover' => $id])->getRow();
        $cek2 = $modelListHandover->getWhere(['id_handover' => $id])->getResult();

        foreach ($cek2 as $q) {
            $datajson[] = [
                'id'            => $q->id,
                'id_handover'   => $q->id_handover,
                'order_id'      => $q->order_id,
                'nama_penerima' => $q->nama_penerima,
                'driver'        => $driver,
                'alamat'        => $q->alamat,
                'no_tlp'        => $q->no_tlp,
            ];
            $modelListHandover->update($q->id, ['status' => 1]);

            $modelOrder->update($q->order_id, ['driver' => $driver]);
        }
        $modelHandover  = new HandoverModel();
        $cekId = $modelHandover->getWhere(['id_handover' => $id])->getResult();
        if (count($cekId) > 0) {
            $json = [
                'error' => "$id sudah ada",
            ];
        } else {
            $query = [
                'id_handover'       => $id,
                'listItem'          => json_encode($datajson),
                'driver'            => $driver,
                'warehouse'         => $warehouse,
            ];
            $modelHandover->insert($query);

            $json = [
                'sukses'    => 'Berhasil membuat manifest',
            ];
        }
        echo json_encode($json);
    }
    function detailHandover()
    {
        if ($this->request->isAjax()) {
            $po = $this->request->getPost('id');

            $modelInvoice = new InvoiceModel();
            $getOrderId = $modelInvoice->getWhere(['id' => $po])->getRow();

            $modelPo = new ModelOrder();
            $ambilData = $modelPo->getWhere(['Order_id' => $getOrderId->Order_id])->getRow();

            $modelPacking = new PackingModel();
            $ambilData1 = $modelPacking->getWhere(['order_id' => $getOrderId->Order_id])->getRow();

            $modelListHandover = new ModelListHandover();
            $ambilData2 = $modelListHandover->getWhere(['order_id' => $getOrderId->Order_id])->getRow();

            $modelHandover = new HandoverModel();
            $ambilData3 = $modelHandover->getWhere(['id_handover' => $ambilData2->id_handover])->getRow();

            $data = [
                'Order_id'          => $getOrderId->Order_id,
                'time_slot'         => $ambilData->created_at,
                'time_packing'      => $ambilData1->updated_at,
                'foto_before'       => $ambilData1->foto,
                'foto_after'        => $ambilData1->foto_after,
                'foto_handover'     => $ambilData3->foto,
                'tandatangan'       => $ambilData3->tandatangan,
                'driver'            => $ambilData3->driver,
                'penerima'          => $ambilData->Drop_name,
                'alamat'            => $ambilData->Drop_address,
                'no_tlp'            => $ambilData->Drop_contact,
            ];
            $json = [
                'data'  => view('Laporan/dataTemp', $data)
            ];
            echo json_encode($json);
        }
    }
}
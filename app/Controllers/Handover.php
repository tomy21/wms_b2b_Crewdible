<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;
use App\Models\InvoiceModel;
use App\Models\ModelHistoryOutbound;
use App\Models\ModelListHandover;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use Config\Services;


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

        $request = Services::request();
        $modelOrder = new ModelOrder($request);
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

                $modelPacking   = new PackingModel($request);
                $getId          = $modelPacking->getWhere(['order_id' => $order])->getResult();
                $idData = null;
                foreach($getId as $y){
                    $idData = $y->id;
                }
                $modelPacking->update($idData, ['Status' => 3]);

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

        $request = Services::request();
        $modelOrder     = new ModelOrder($request);
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
        $request = Services::request();
        $datatable = new ModelHistoryOutbound($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                // data invoice 
                $modelInvoice = new InvoiceModel();
                $count = $modelInvoice->where(['Order_id' => $list->Order_id])->countAllResults();
                $sumData = 0;
                $idInv = [];
                $query = $modelInvoice->where(['Order_id' => $list->Order_id])->get()->getResult();
                foreach ($query as $x) {
                    $sumData += $x->quantity;
                    $idInv = $x->id;
                }

                // data Packing
                $modelPacking = new PackingModel($request);
                $queryPacking = $modelPacking->getWhere(['order_id' => $list->Order_id])->getResult();
                $sumPacking = 0;
                $countPacking = 0;
                $datePacking = [];
                foreach ($queryPacking as $z) {
                    foreach (json_decode($z->list) as $y) {
                        $sumPacking += intval($y->quantity);
                    }
                    $jsonData = json_decode($z->list, true);
                    $countPacking = count($jsonData);
                    $datePacking = $z->updated_at;
                }

                // date Handover 
                $modelHandover = new ModelListHandover();
                $queryHandover = $modelHandover->getWhere(['order_id' => $list->Order_id])->getResult();
                $updatedHandover = [];
                foreach ($queryHandover as $p) {
                    $updatedHandover = $p->updated_at;
                }

                $buttonDetail = "<button class=\"btn btn-sm btn-info\" type=\"button\" 
                onclick=\"detail('$idInv')\"><i class=\"fa fa-eye\"></i></button>";
                $btnEdit = "<button class=\"btn btn-sm btn-warning\" type=\"button\" onclick=\"edit('$list->Order_id')\"><i class=\"fa fa-edit\"></i></button>";
                
                $btn = "$buttonDetail &nbsp $btnEdit";

                $row[] = $no;
                $row[] = $list->stock_location;
                $row[] = $list->Order_id;
                $row[] = $sumData;
                $row[] = $sumPacking;
                $row[] = $count;
                $row[] = $countPacking;
                $row[] = $list->created_at;
                $row[] = $datePacking == null ? '-' : $datePacking;
                $row[] = $updatedHandover == null ? '-' : $updatedHandover;
                $row[] = $list->created_at <= $datePacking ? "<span class=\" badge badge-danger\">Over SLA</span>" : "<span class=\"badge badge-success\">Meet SLA</span>";
                $row[] = $buttonDetail ;
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    function dataDetail()
    {
        if ($this->request->isAjax()) {
            $po = $this->request->getPost('id');

            $request = Services::request();
            $modelInvoice = new InvoiceModel();
            $getOrderId = $modelInvoice->getWhere(['id' => $po])->getRow();

            $modelPo = new ModelOrder($request);
            $ambilData = $modelPo->getWhere(['Order_id' => $getOrderId->Order_id])->getResult();
            $created_at = null;
            $Drop_name = null;
            $Drop_address = null;
            $Drop_contact = null;
            foreach ($ambilData as $a) {
                $created_at = $a->created_at;
                $Drop_name = $a->Drop_name;
                $Drop_address = $a->Drop_address;
                $Drop_contact = $a->Drop_contact;
            }

            $modelPacking = new PackingModel($request);
            $ambilData1 = $modelPacking->getWhere(['order_id' => $getOrderId->Order_id])->getResult();
            $foto = null;
            $updated_at = null;
            $foto_after = null;
            foreach ($ambilData1 as $a1) {
                $foto = $a1->foto;
                $updated_at = $a1->updated_at;
                $foto_after = $a1->foto_after;
            }

            $modelListHandover = new ModelListHandover();
            $ambilData2 = $modelListHandover->getWhere(['order_id' => $getOrderId->Order_id])->getResult();
            $idHandover = null;
            foreach ($ambilData2 as $y) {
                $idHandover = $y->id_handover;
            }

            $modelHandover = new HandoverModel();
            $ambilData3 = $modelHandover->getWhere(['id_handover' => $idHandover])->getResult();
            $foto1 = null;
            $tandatangan = null;
            $driver = null;
            foreach ($ambilData3 as $a3) {
                $foto1 = $a3->foto;
                $tandatangan = $a3->tandatangan;
                $driver = $a3->driver;
            }


            $data = [
                'Order_id' => $getOrderId->Order_id,
                'time_slot' => $created_at,
                'time_packing' => $updated_at,
                'foto_before' => $foto,
                'foto_after' => $foto_after,
                'foto_handover' => $foto1,
                'tandatangan' => $tandatangan,
                'driver' => $driver,
                'penerima' => $Drop_name,
                'alamat' => $Drop_address,
                'no_tlp' => $Drop_contact,
            ];
            $json = [
                'data' => view('Laporan/dataTemp', $data)
            ];
            echo json_encode($json);
        }
    }
    function editData()
    {
        $po = $this->request->getPost('id');

        $request = Services::request();
        $modelInvoice = new PackingModel($request);
        $getOrderId = $modelInvoice->getWhere(['order_id' => $po])->getResult();
        $updated_at = null;
        foreach ($getOrderId as $y) {
            $updated_at = $y->updated_at;
        }
        $data = [
            'Order_id' => $po,
            'updated_at' => $updated_at,
        ];

        $json = [
            'data'  => view('Laporan/editData', $data),
        ];

        echo json_encode($json);
    }
    function UpdateDate()
    {
        $id     = $this->request->getVar('orderId');
        $date   = $this->request->getVar('date');
        $estimate   = strtotime($date);

        $request = Services::request();
        $modalPacking   = new PackingModel($request);
        
        $modalPacking->update($id,['updated_at'     => date('Y-m-d H:i:s', $estimate)]);

        $json = [
            'success' => 'Data berhasil di update'
        ];

        echo json_encode($json);
    }
    function hapusData(){
        $id = $this->request->getPost('id');

        $modelList = new ModelListHandover();
        $getData    = $modelList->getWhere(['order_id'=>$id])->getResult();
        $idData = null;
        foreach($getData as $x){
            $idData = $x->id;
        }
        $modelList->delete($idData);

        $json = [
            'sukses' => 'Data berhasil di hapus'
        ];

        echo json_encode($json);
    }
}

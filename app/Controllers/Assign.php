<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelMasterBasket;
use App\Models\ModelOrder;
use App\Models\PickingModel;

class Assign extends BaseController
{
    public function index()
    {
        $modelInvoice   = new InvoiceModel();
        $sum            = $modelInvoice->group_item();
        $cekData        = $modelInvoice->getWhere(['status' => 1]);
        $jumlah = 0;
        foreach ($sum as $row) :
            $jumlah += intval($row['qty']);
        endforeach;
        $data = [
            'data'              => $modelInvoice->group_item(),
            'countOrder'        => $cekData->getNumRows(),
            'total'             => $jumlah,

        ];
        return view('assign/index', $data);
    }
    public function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $modelTemp = new InvoiceModel();
            $data = [
                'datatemp' => $modelTemp->group_item()
            ];
            $json = [
                'data' => view('/assign/dataTemp', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function cariBarang()
    {
        if ($this->request->isAJAX()) {
            $modalStock = new InvoiceModel();
            $json = [
                'data' => view('assign/modalBarang')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function ProsesPick()
    {
        $id   = $this->request->getVar('id');
        $assign = $this->request->getVar('picker');
        $basket = $this->request->getVar('basket');
        $warehouse = $this->request->getVar('warehouse');
        $modelInvoice = new InvoiceModel();
        $modelPicking = new PickingModel();
        $modelBasket = new ModelMasterBasket();

        $count = count($id);

        // $count = $cekCode->getNumRows();
        $cekKap         = $modelBasket->find($basket);

        if ($count > $cekKap['kapasitas']) {
            $json = [
                'error'     => 'Basket tidak cukup maksimal 15 Pcs, gunakan basket lain !',
            ];
        } else {
            $jumlahKapasitas = 0;
            $cekBasket = $modelInvoice->getWhere(['id_basket' => $basket])->getResult();
            foreach ($cekBasket as $row) {
                $jumlahKapasitas += $row->quantity;
            }
            // $cekBasketKap   = $modelBasket->getWhere(['id_basket' => $basket])->getResult();
            $cekKap         = $modelBasket->find($basket);

            if ($cekKap['kap_order'] > $cekKap['kapasitas']) {
                $json = [
                    'error'     => 'Basket penuh, gunakan basket lain !',
                ];
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $cekData = $modelInvoice->where(['Item_id' => $id[$i], 'status' => 1, 'warehouse' => $warehouse])->get();
                    // print_r($modelInvoice->getLastQuery()->getQuery());
                    // die;
                    foreach ($cekData->getResult() as $data) {
                        $idData = $data->id;
                        $data = [
                            'assign'    => $assign,
                            'status'    => 2,
                            'id_basket' => $basket,
                        ];
                        $modelInvoice->update($idData, $data);
                    }
                }
                $status = 1;
                $dataBasket = [
                    'kap_order'     => $jumlahKapasitas,
                    'status'        => $status,
                ];
                $modelBasket->update($basket, $dataBasket);
                $json = [
                    'sukses' => "Berhasil Assign Picker "
                ];
            }
        }


        echo json_encode($json);
    }
    function assign()
    {
        $modelInvoice   = new InvoiceModel();
        $modelPicking   = new PickingModel();
        $modelOrder     = new ModelOrder();
        $tampilData     = $modelInvoice->group_item();

        $cek = $modelInvoice->getWhere(['status' => 2])->getResult();
        if ($cek == null) {
            $json = [
                'error'    => 'Belum ada yang di assign'
            ];
        } else {
            foreach ($tampilData as $row) {
                $modelPicking->insert([
                    'id_basket'         => $row['id_basket'],
                    'Item_id'           => $row['Item_id'],
                    'Item_detail'       => $row['Item_detail'],
                    'qty'               => $row['jumlah'],
                    'assign'            => $row['nama_user'],
                    'warehouse'         => user()->warehouse,
                ]);
                $cek = $modelInvoice->getWhere(['status' => 2])->getResult();
                foreach ($cek as $data) {
                    $modelInvoice->update($data->id, ['status' => 3]);
                    $modelOrder->update($data->id, ['status' => 3]);
                }
            }
            $json = [
                'sukses'    => 'Data barhasil di assign'
            ];
        }

        echo json_encode($json);
    }
}
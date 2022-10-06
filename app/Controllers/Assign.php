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
        $cekData = $modelInvoice->whereIn('Item_id', $id)->where('stock_location', $warehouse)->where('status', 1)->get();

        foreach ($cekData->getResult() as $data) {
            $idData = $data->id;

            $data1 = [
                'assign'    => $assign,
                'status'    => 2,
                'id_basket' => $basket,
            ];
            $modelInvoice->update($data1, ['id'=>$idData]);
        }

        $modelBasket->update($basket, ['status' => 1]);

        $json = [
            'sukses' => "Berhasil Assign Picker "
        ];

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
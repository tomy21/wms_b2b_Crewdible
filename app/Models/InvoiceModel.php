<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'tbl_invoice';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'Order_id',    'Item_id',    'Item_detail',    'quantity',    'volume', 'Vehicle_tag',    'Drop_name', 'Drop_contact', 'Drop_address', 'Drop_city', 'Drop_country',
        'Drop_zipcode',    'Drop_latitude', 'Drop_longitude',    'Transaction_time',    'Drop_date',
        'Drop_start_time', 'Drop_end_time', 'Payment_methode',    'Amount',    'Note',
        'stock_location', 'status', 'assign', 'id_basket', 'created_at'
    ];
    protected $useTimestamps    = true;

    function tampilDataTransaksi()
    {
        return $this->table('tbl_invoice')->where('status', 1)->get()->getResultArray();
    }
    function tampilDataInv()
    {
        return $this->table('tbl_invoice')->get()->getResultArray();
    }
    function tampilData()
    {
        return $this->table('tbl_invoice')->where('status', 2)->get()->getResultArray();
    }
    public function dataDetail($orderId)
    {
        return $this->table('tbl_invoice')->where(['Order_id' => $orderId])->get();
    }
    public function cekResi($sku)
    {
        return $this->table('tbl_invoice')->getWhere(['sha1(Item_id)' => $sku]);
    }
    public function add($data)
    {
        $this->db->table('tbl_invoice')->insert($data);
    }

    public function update_set($sku, $data)
    {
        $this->db->table('tbl_invoice')->set($data)->where('Item_id', $sku)->update($sku, $data);
    }
    public function cekData($sku)
    {
        return $this->db->table('tbl_invoice')->where('Item_id', $sku)->get()->getRowArray();
    }
    public function dataStatus()
    {
        return $this->db->table('tbl_invoice')->select(' Order_id,Drop_name,Drop_address,Drop_contact,Drop_city,stock_location,status')
            ->groupBy('Order_id')->get()->getResult();
    }
    public function getDataSorting()
    {
        return $this->db->table('tbl_invoice')->where('status', 3)->select(' Order_id,Drop_name,Drop_address,Drop_contact,Drop_city,stock_location,status,sum(quantity) as jumlah,')
            ->groupBy('Order_id')->get()->getResult();
    }
    public function getDataItem()
    {
        return $this->db->table('tbl_invoice')->select(' Order_id,assign,Item_id,Item_detail,status, sum(quantity) as jumlah, count(Order_id) as order')
            ->groupBy('Order_id')->get()->getResult();
    }
    // public function getDataItem()
    // {
    //     return $this->db->table('tbl_invoice')->select(' Order_id,assign,Item_id,Item_detail,status, sum(quantity) as jumlah, id_basket')
    //     ->groupBy('Order_id')->get()->getResultArray();
    // }
    public function getDetailCount()
    {
        return $this->db->table('tbl_invoice')->select('status, , count("status") as jumlah')
            ->groupBy('status')->get()->getResult();
    }
    public function group_driver()
    {
        return $this->db->table('tbl_invoice')->where('status', 2)->select('Order_id,assign, Item_id,Item_detail,status, sum(quantity) as jumlah, count(Order_id) as qty,count(assign) as picker,count(Item_id) as item')
            ->groupBy('assign')->get();
    }
    public function group_order()
    {
        return $this->db->table('tbl_invoice')->select('Order_id,assign, Item_id,Item_detail,status, sum(quantity) as jumlah, count(Order_id) as qty,count(assign) as picker')
            ->groupBy('Order_id')->get()->getResult();
    }

    public function filterDriver($namaDriver)
    {
        return $this->table('tbl_invoice')->like('Order_id', $namaDriver)->get();
    }
    public function filterData($assign)
    {
        return $this->table('tbl_invoice')->like('assign', $assign)->get();
    }
    public function filterOrder($order)
    {
        return $this->table('tbl_invoice')->like('Order_Id', $order)->getResult();
    }
    public function group_item()
    {
        return $this->db->table('tbl_invoice')->join('tbl_karyawan', 'tbl_karyawan.id_user = tbl_invoice.assign')->select('Order_id,assign, Item_id,Item_detail, sum(quantity) as jumlah, count(Order_id) as qty, id_basket,nama_user')->where('status', 2)
            ->groupBy('assign,Item_id', 'id_basket')->get()->getResultArray();
    }
    public function tampilDataTemp($order)
    {
        return $this->table('tbl_invoice')->where(['Order_id' => $order])->get();
    }
    public function tampilDataPicker($user)
    {
        return $this->table('tbl_invoice')->where(['Assign' => $user])->select('Order_id,Assign, Item_id,Item_detail,status, sum(quantity) as jumlah, count(Order_id) as qty,count(Assign) as assign')
            ->groupBy('Item_id')->get();
    }
    public function tampilDataDriver($driver)
    {
        return $this->table('tbl_invoice')->where(['Order_id' => $driver])->get();
    }
    public function cekOrder($order)
    {
        return $this->table('tbl_invoice')->getWhere([
            'Order_id' => $order
        ]);
    }
    public function filter_OrderID()
    {
        return $this->table('tbl_invoice')->orderBy('Order_id', 'desc')->get();
    }
    public function cekTransaksi($order)
    {
        return $this->table('tbl_invoice')->getWhere([
            'sha1(Order_id)' => $order
        ]);
    }
    public function reportPeriode($tglawal, $tglakhir)
    {
        return $this->table('tbl_invoice')->where('status', 5)->where('created_at>=', $tglawal)->where('created_at<=', $tglakhir)->get();
    }
    public function sumData()
    {
        $bulder = $this->db->table('tbl_invoice');
        $bulder->selectSum('quantity');
        $query = $bulder->get();
        return $query;
    }

    public function tblJoind()
    {
        $query =  $this->db->table('tbl_invoice')
            ->join('tbl_masteritem', 'tbl_invoice.Item_id = tbl_masteritem.item_id')
            ->get();
        return $query;
    }
    public function cariData($cari)
    {
        return $this->table('tbl_invoice')->like('Item_id', $cari);
    }
}
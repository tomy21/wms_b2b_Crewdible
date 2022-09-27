<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOrder extends Model
{
    protected $table            = 'tbl_order';
    protected $primaryKey       = 'Order_id';
    protected $allowedFields    = [
        'status'
    ];
    protected $useTimestamps = true;

    public function add($data2)
    {
        $this->db->table('tbl_order')->ignore(true)->insert($data2);
    }
    public function dataDetail($order)
    {
        return $this->table('tbl_order')->join('tbl_invoice', 'Order_id=Order_id')->where('Order_id', $order)->get();
    }
    function tampilDataTransaksi()
    {
        return $this->table('tbl_order')->get()->getResultArray();
    }
    public function cekOrder($order)
    {
        return $this->db->table('tbl_order')->getWhere([
            'Order_id' => $order
        ]);
    }
    public function getData($orderid)
    {
        return $this->db->table('tbl_order')->where('Order_id', $orderid)->get()->getRowArray();
    }
    public function countData()
    {
        return $this->db->table('tbl_order')->where('status', 1)->get();
    }
}
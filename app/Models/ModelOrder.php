<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOrder extends Model
{
    protected $table            = 'tbl_order';
    protected $primaryKey       = 'Order_id';
    protected $allowedFields    = ['driver', 'status', 'created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city'];
    protected $useTimestamps    = true;
    // protected $column_order     = array(null, 'created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city', null, null);
    // protected $column_search    = array('created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city');
    // protected $order            = array(['created_at' => 'asc', 'stock_location' => 'asc', 'Order_id' => 'asc', 'Drop_name' => 'asc', 'Drop_contact' => 'asc']);
    // protected $request;
    // protected $dt;
    // protected $db;

    function tampilDataInvoice($katakunci = null, $start = 0, $length = 0)
    {
        $builder = $this->table('tbl_order');
        if ($katakunci) {
            $arr = explode(" ", $katakunci);
            for ($i = 0; $i < count($arr); $i++) {
                $builder = $builder->orLike('created_at', $arr[$i]);
                $builder = $builder->orLike('stock_location', $arr[$i]);
                $builder = $builder->orLike('Order_id', $arr[$i]);
                $builder = $builder->orLike('Drop_name', $arr[$i]);
                $builder = $builder->orLike('Drop_contact', $arr[$i]);
                $builder = $builder->orLike('Drop_city', $arr[$i]);
                $builder = $builder->orLike('status', $arr[$i]);
            }
        }

        if ($start != 0  or $length != 0) {
            $builder = $builder->limit($length, $start);
        }

        return $builder->get()->getResult();
    }
    public function add($orderNow2)
    {
        $this->db->table('tbl_order')->ignore(true)->insert($orderNow2);
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
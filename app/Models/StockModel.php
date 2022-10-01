<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table            = 'tbl_stock';
    protected $primaryKey       = 'Item_id';
    protected $allowedFields    = ['Item_id', 'Item_detail', 'quantity_good', 'quantity_reject', 'qty_received', 'warehouse','sku'];
    protected $useTimestamps    = true;

    function tampilDataTransaksi($warehouse)
    {
        return $this->table('tbl_stock')->getWhere(['warehouse' => $warehouse])->getResultArray();
    }
    public function dataDetail($item_id)
    {
        return $this->table('tbl_stock')->where('Item_id', $item_id)->get();
    }
    public function cekResi($item_id)
    {
        return $this->table('tbl_stock')->getWhere(['sha1(Item_id)' => $item_id]);
    }
    public function add($data)
    {
        $this->db->table('tbl_stock')->insert($data);
    }
    public function update_set($item_id, $data)
    {
        $this->db->table('tbl_stock')->where('Item_id', $item_id)->update($item_id, $data);
    }
    public function cekData($item_id)
    {
        return $this->db->table('tbl_stock')->where('Item_id', $item_id)->get()->getRowArray();
    }
}
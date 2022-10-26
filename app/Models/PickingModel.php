<?php

namespace App\Models;

use CodeIgniter\Model;

class PickingModel extends Model
{
    protected $table            = 'tbl_picking';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['Item_id', 'Item_detail', 'qty', 'quantity_pick', 'assign', 'status', 'id_basket', 'warehouse'];
    protected $useTimestamps    = true;

    function tampilDataTransaksi($warehouse)
    {
        return $this->table('tbl_picking')->getWhere(['warehouse' => $warehouse, 'updated_at' => date('Y-m-d')])->getResultArray();
    }
    public function getPickCount()
    {
        return $this->db->table('tbl_picking')->select(' id, Assign, Item_id,Item_detail,status,quantity_pick, sum(qty) as jumlah')
            ->groupBy('Assign')->get();
    }
    public function filterData($assign)
    {
        return $this->table('tbl_picking')->like('assign', $assign)->get();
    }
    public function dataDetail($id)
    {
        return $this->table('tbl_picking')->where('id', $id)->get();
    }
    public function tampilDataPicker($user)
    {
        return $this->table('tbl_picking')->where(['Assign' => $user])->select('Assign, Item_id,Item_detail,Status, sum(qty) as jumlah,count(Assign) as assign, quantity_pick')
            ->groupBy('Item_id')->get();
    }
    public function getDataItem()
    {
        return $this->db->table('tbl_picking')->select(' assign,Item_id,Item_detail,status, sum(quantity) as jumlah')
            ->groupBy('Item_id')->get();
    }
    public function group_driver()
    {
        return $this->db->table('tbl_picking')->select('assign,Item_id,Item_detail,status, quantity_pick ,qty, sum(qty) as jumlah, count(Item_id) as item')
            ->groupBy('assign')->get();
    }
    public function cekTransaksi($assign)
    {
        return $this->table('tbl_invoice')->getWhere([
            'sha1(assign)' => $assign
        ]);
    }
    public function cekTransaksiPicking($item)
    {
        return $this->table('tbl_picking')->getWhere([
            'Item_id' => $item
        ]);
    }
    public function add($data3)
    {
        $this->db->table('tbl_picking')->insert($data3);
    }
}
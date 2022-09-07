<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReturnReject extends Model
{
    protected $table            = 'tbl_returnreject';
    protected $primaryKey       = 'Item_id';
    protected $allowedFields    = ['Order_id', 'Item_id', 'Item_detail', 'qty', 'Receive', 'Status', 'Reason'];
    protected $useTimestamps    = true;

    function tampilDataTransaksi()
    {
        return $this->table('tb_returnreject')->get();
    }
    public function dataDetail($idItem)
    {
        return $this->table('tb_returnreject')->where('Item_id', $idItem)->get();
    }
}
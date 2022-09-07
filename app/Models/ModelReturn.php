<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReturn extends Model
{
    protected $table            = 'tb_return';
    protected $primaryKey       = 'Item_id';
    protected $allowedFields    = ['Order_id', 'Item_id', 'Item_detail', 'qty', 'Receive', 'Status', 'Reason'];
    protected $useTimestamps    = true;

    function tampilDataTransaksi()
    {
        return $this->table('tb_return')->get()->getResultArray();
    }
    public function dataDetail($idItem)
    {
        return $this->table('tb_return')->where('Item_id', $idItem)->get();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class UploadPoModel extends Model
{
    protected $table            = 'tbl_inbound';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['nopo', 'item_id', 'item_name', 'quantity'];

    public function add($data)
    {
        $this->db->table('tbl_inbound')->insert($data);
    }
    function tampilDataTransaksi()
    {
        return $this->table('tbl_inbound')->get();
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tbl_inbound')->like('item_id', $cari);
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelWarehouse extends Model
{
    protected $table            = 'tbl_warehouse';
    protected $primaryKey       = 'id_warehouse';
    protected $allowedFields    = ['id_warehouse', 'warehouse_name'];

    public function idWarehosue()
    {
        $kode = $this->db->table('tbl_warehouse')->select('RIGHT(id_warehouse,3) as id', false)->orderBy('id_warehouse', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $awal = "WH-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $noId = $awal . $tgl . $batas;
        return $noId;
    }
    
}
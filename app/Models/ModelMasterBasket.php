<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMasterBasket extends Model
{
    protected $table            = 'tbl_masterbasket';
    protected $primaryKey       = 'id_basket';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'id_basket', 'kapasitas', 'type', 'kap_order', 'status'
    ];

    public function idBasket()
    {
        $kode = $this->db->table('tbl_masterbasket')->select('RIGHT(id_basket,3) as id', false)->orderBy('id_basket', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $awal = "Cart";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $noManifest = $awal . $l . $tgl . $batas;
        return $noManifest;
    }
}
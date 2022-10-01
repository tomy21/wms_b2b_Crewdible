<?php

namespace App\Models;

use CodeIgniter\Model;

class PoModel extends Model
{
    protected $table            = 'tbl_po';
    protected $primaryKey       = 'no_Po';
    protected $allowedFields    = ['no_Po', 'driver', 'noplat', 'foto', 'tandatangan', 'jumlah_item', 'quantity_item', 'status', 'quantity_count', 'selisih'];
    protected $useTimestamps    = true;

    public function add($data)
    {
        $this->db->table('tbl_po')->insert($data);
    }
    function tampilDataTransaksi()
    {
        return $this->table('tbl_po')->get();
    }
    public function buatPo()
    {
        $kode = $this->db->table('tbl_po')->select('RIGHT(no_Po,3) as no_Po', false)->orderBy('no_Po', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['no_Po']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['no_Po']) + 1;
        }

        $tgl = date('ymd');
        $awal = "PO";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $noManifest = $awal . $l . $tgl . $batas;
        return $noManifest;
    }
}
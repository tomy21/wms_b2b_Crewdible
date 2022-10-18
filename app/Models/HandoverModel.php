<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverModel extends Model
{
    protected $table            = 'tbl_handover';
    protected $primaryKey       = 'id_handover';
    protected $allowedFields    = ['id_handover', 'listItem', 'driver', 'foto', 'tandatangan', 'status', 'warehouse'];
    protected $useTimestamps    = true;

    public function idHandover()
    {
        $kode = $this->db->table('tbl_handover')->select('RIGHT(id_handover,3) as id', false)->orderBy('id_handover', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $noId = $tgl . $batas;
        return $noId;
    }
}
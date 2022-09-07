<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKaryawan extends Model
{
    protected $table            = 'tbl_karyawan';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = ['id_user', 'nama_user', 'email', 'level', 'password', 'warehouse', 'status_kar'];
    protected $useTimestamps = true;

    function tampilData()
    {
        return $this->table('tbl_karyawan')->get();
    }
    public function idKaryawan()
    {
        $kode = $this->db->table('tbl_karyawan')->select('RIGHT(id_user,3) as id', false)->orderBy('id_user', 'DESC')->limit(1)->get()->getRowArray();

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
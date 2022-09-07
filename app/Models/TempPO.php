<?php

namespace App\Models;

use CodeIgniter\Model;

class TempPO extends Model
{
    protected $table            = 'tbl_tempinbound';
    protected $primaryKey       = 'Item_id';
    protected $allowedFields    = ['nopo', 'Item_id', 'Item_detail', 'quantity', 'volume', 'created_at'];
    protected $useTimestamps    = true;

    public function tampilDataTemp($nopo)
    {
        return $this->table('tbl_tempinbound')->where(['nopo' => $nopo])->get();
    }

    function tampilDataTransaksi()
    {
        return $this->table('tbl_tempinbound')->get();
    }
    public function dataDetail($nopo)
    {
        return $this->table('tbl_tempinbound')->where('No_Po', $nopo)->get();
    }
    public function cekFaktur($nopo)
    {
        return $this->table('tbl_tempinbound')->getWhere([
            'nopo' => $nopo
        ]);
    }
}
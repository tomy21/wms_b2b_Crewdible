<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogInbound extends Model
{
    protected $table            = 'tbl_loginbound';
    protected $primaryKey       = 'nopo';
    protected $allowedFields    = ['nopo', 'Item_id', 'Item_detail', 'quantity', 'stock_good', 'stock_bad', 'selisih', 'warehouse'];
    protected $useTimestamps    = true;


    public function reportPeriode($tglawal, $tglakhir)
    {
        return $this->table('tbl_loginbound')->where('created_at>=', $tglawal)->where('created_at<=', $tglakhir)->get();
    }
}
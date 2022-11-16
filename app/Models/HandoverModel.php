<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverModel extends Model
{
    protected $table            = 'tbl_handover';
    protected $primaryKey       = 'id_handover';
    protected $allowedFields    = ['id_handover', 'listItem', 'driver', 'foto', 'tandatangan', 'status', 'warehouse'];
    protected $useTimestamps    = true;

    public function idHandover($code = null)
    {
        $kode = $this->db->table('tbl_handover')->select('RIGHT(id_handover,3) as id', false)->orderBy('id_handover', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $warehouse = new ModelWarehouse();
        $code = user()->warehouse;
        $dataWarehouse = $warehouse->getWhere(['warehouse_name'=> $code])->getResult();
        $codeWh = null;
        foreach($dataWarehouse as $t){
            $codeWh = $t->warehouse_code;
        }
        $tgl = date('ymd');
        $p  = '-';
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $noId = $codeWh . $p . $tgl . $batas;
        return $noId;
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class InboundModel extends Model
{
    protected $table            = 'tbl_inbound';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nopo', 'warehouse', 'Item_id', 'Item_detail', 'quantity', 'volume'];
    protected $useTimestamps    = true;

    public function add($data)
    {
        $this->db->table('tbl_inbound')->insert($data);
    }
    function tampilDataTransaksi()
    {
        return $this->table('tbl_inbound')->get();
    }
    public function dataDetail($nopo)
    {
        return $this->table('tbl_inbound')->where('nopo', $nopo)->get();
    }
    public function cekFaktur($nopo)
    {
        return $this->table('tbl_inbound')->getWhere([
            'sha1(nopo)' => $nopo
        ]);
    }
    public function getDataCount()
    {
        return $this->db->table('tbl_inbound')->select('count(Item_id) as countItem')->get();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelItem extends Model
{
    protected $table            = 'tbl_item';
    protected $primaryKey       = 'Item_id';
    protected $allowedFields    = ['Item_id','Item_detail','quantity','volume','Amount','Note'];
    protected $useTimestamps    = true;

    public function add($data2){
        $this->db->table('tbl_item')->ignore(true)->insert($data2);
    }
}

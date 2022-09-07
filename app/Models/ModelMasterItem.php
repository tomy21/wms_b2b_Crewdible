<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMasterItem extends Model
{
    protected $table            = 'tbl_masteritem';
    protected $primaryKey       = 'item_id';
    protected $allowedFields    = [
        'item_id', 'vendor_id', 'item_name', 'volume', 'status'
    ];
}
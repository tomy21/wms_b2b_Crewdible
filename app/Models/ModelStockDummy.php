<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStockDummy extends Model
{
    protected $table            = 'tbl_stockdummy';
    protected $primaryKey       = 'Item_id';
    protected $allowedFields    = ['nopo', 'Item_id', 'Item_detail', 'quantity', 'stock_good', 'stock_bad', 'warehouse'];
    protected $useTimestamps    = true;
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStatusTransaksi extends Model
{
    protected $table            = 'tbl_returnreject';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['status'];
}
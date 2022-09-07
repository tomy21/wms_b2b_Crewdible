<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAssign extends Model
{
    protected $table            = 'tbl_assign';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['NamaDriver','UserAsign'];
    protected $useTimestamps = true;

}

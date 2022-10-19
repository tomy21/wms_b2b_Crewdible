<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelListHandover extends Model
{
    protected $table            = 'tbl_listhandover';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_handover', 'order_id', 'driver', 'nama_penerima', 'alamat', 'no_tlp', 'status', 'updated_at'];
    protected $useTimestamps    = true;
}
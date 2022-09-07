<?php

namespace App\Models;

use CodeIgniter\Model;

class HandoverModel extends Model
{
    protected $table            = 'tbl_handover';
    protected $primaryKey       = 'id_handover';
    protected $allowedFields    = ['Order_id', 'listItem', 'driver', 'foto', 'tandatangan'];
    protected $useTimestamps    = true;
}
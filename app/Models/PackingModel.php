<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingModel extends Model
{
    protected $table            = 'tbl_packing';
    protected $primaryKey       = 'order_id';
    protected $allowedFields    = ['order_id', 'list', 'foto', 'foto_after', 'assign', 'warehouse', 'Status','updated_at'];
    protected $useTimestamps    = true;

    public function tampilDataTemp($order)
    {
        return $this->table('tbl_packing')->where(['order_id' => $order])->get();
    }
    function qr($id)
    {
        if ($id) {
            $filename = 'public/dist/img/' . $id;
            if (!file_exists($filename)) {
                $this->load->libraries('ciqrcode');
                $params['data'] = $id;
                $params['level'] = 'H';
                $params['size'] = 10;
                $params['savename'] = FCPATH . 'qr/' . $id . ".png";
                return  $this->ciqrcode->generate($params);
            }
        }
    }
}
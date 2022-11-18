<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class HandoverModel extends Model
{
    protected $table            = 'tbl_handover';
    protected $primaryKey       = 'id_handover';
    protected $allowedFields    = ['id_handover', 'listItem', 'driver', 'foto', 'tandatangan', 'status', 'warehouse'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'created_at', 'warehouse', 'id_handover', null, 'driver', 'foto', 'tandatangan', null);
    protected $column_search    = array('created_at', 'warehouse', 'id_handover', 'driver', 'foto', 'tandatangan', 'status');
    protected $order            = array('created_at' => 'desc');
    protected $request;
    protected $dt;
    protected $db;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
    }
    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $_POST['search']['value']);
                } else {
                    $this->dt->orLike($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }
        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        $warehouse = user()->warehouse;
        if ($_POST['length'] != -1)
            $this->dt->limit($_POST['length'], $_POST['start']);
        if ($warehouse == "Headoffice") {
            $query = $this->dt->get();
        } else {
            $query = $this->dt->where(['warehouse' => $warehouse, 'created_at>=' => date('Y-m-d', strtotime('-1 days'))])->get();
        }
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $warehouse = user()->warehouse;
        $tbl_storage = $this->dt->where(['warehouse' => $warehouse,'created_at>=' => date('Y-m-d', strtotime('-1 days'))]);
        return $tbl_storage->countAllResults();
    }

    public function idHandover($code = null)
    {
        $warehouse = new ModelWarehouse();
        $code = user()->warehouse;

        $kode = $this->db->table('tbl_handover')->where('warehouse',$code)->select('RIGHT(id_handover,4) as id', false)->orderBy('id_handover', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        
        $dataWarehouse = $warehouse->getWhere(['warehouse_name'=> $code])->getResult();
        $codeWh = null;
        foreach($dataWarehouse as $t){
            $codeWh = $t->warehouse_code;
        }
        $tgl = date('ymd');
        $p  = '-';
        $batas = str_pad($no, 4, "0", STR_PAD_LEFT);
        $noId = $codeWh . $p . $tgl . $batas;
        return $noId;
    }
}
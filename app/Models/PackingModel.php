<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PackingModel extends Model
{
    protected $table            = 'tbl_packing';
    protected $primaryKey       = 'order_id';
    protected $allowedFields    = ['order_id', 'list', 'foto', 'foto_after', 'assign', 'warehouse', 'Status','updated_at'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'order_id', 'warehouse', null, null, 'foto', 'foto_after', 'assign','status', 'updated_at');
    protected $column_search    = array('order_id', 'warehouse', 'assign', 'updated_at', 'status');
    protected $order            = array('updated_at' => 'desc');
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

        if ($warehouse == "Headoffice"){
            $query = $this->dt->where(['created_at>=' => date('Y-m-d',strtotime('-1 days'))])->get();
        }else{
            $query = $this->dt->where(['warehouse'=>$warehouse,'created_at>='=>date('Y-m-d', strtotime('-1 days'))])->get();
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
        $tbl_storage = $this->dt->where(['warehouse' => $warehouse, 'created_at>=' => date('Y-m-d', strtotime('-1 days'))]);
        return $tbl_storage->countAllResults();
    }

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
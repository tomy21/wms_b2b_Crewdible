<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class ModelHistoryOutbound extends Model
{
    protected $table            = 'tbl_order';
    protected $primaryKey       = 'Order_id';
    protected $allowedFields    = ['driver', 'status', 'created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'stock_location', 'Order_id', null, null, null, null, 'created_at', null, null, 'status', null);
    protected $column_search    = array('created_at', 'stock_location', 'Order_id');
    protected $order            = array('Order_id' => 'desc');
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

        $mulai = $this->request->getPost('start_date');
        $akhir = $this->request->getPost('end_date');

        if($mulai != '' && $akhir != '' ){
            $this->dt->getWhere(['created_at>=' => $mulai,'created_at<='=>$akhir]);
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
        if ($_POST['length'] != -1)
            $this->dt->limit($_POST['length'], $_POST['start']);
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}

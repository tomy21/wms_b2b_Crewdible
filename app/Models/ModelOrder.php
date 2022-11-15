<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class ModelOrder extends Model
{
    protected $table            = 'tbl_order';
    protected $primaryKey       = 'Order_id';
    protected $allowedFields    = ['driver', 'status', 'created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city', 'status', null);
    protected $column_search    = array('created_at', 'stock_location', 'Order_id', 'Drop_name', 'Drop_contact', 'Drop_city', 'status');
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
            $query = $this->dt->where('stock_location', $warehouse)->get();
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
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }


    public function reportPeriode($tglawal, $tglakhir)
    {
        return $this->table('tbl_order')->where('status', 6)->where('created_at>=', $tglawal)->where('created_at<=', $tglakhir)->get();
    }
    public function add($orderNow2)
    {
        $this->db->table('tbl_order')->ignore(true)->insert($orderNow2);
    }
    public function dataDetail($order)
    {
        return $this->table('tbl_order')->join('tbl_invoice', 'Order_id=Order_id')->where('Order_id', $order)->get();
    }
    function tampilDataTransaksi()
    {
        return $this->table('tbl_order')->get()->getResultArray();
    }
    public function cekOrder($order)
    {
        return $this->db->table('tbl_order')->getWhere([
            'Order_id' => $order
        ]);
    }
    public function getData($orderid)
    {
        return $this->db->table('tbl_order')->where('Order_id', $orderid)->get()->getRowArray();
    }
    public function countData()
    {
        return $this->db->table('tbl_order')->where('status', 1)->get();
    }
}
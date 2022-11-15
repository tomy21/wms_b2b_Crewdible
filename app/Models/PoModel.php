<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PoModel extends Model
{
    protected $table            = 'tbl_po';
    protected $primaryKey       = 'no_Po';
    protected $allowedFields    = ['no_Po', 'driver', 'noplat', 'foto', 'tandatangan', 'jumlah_item', 'quantity_item', 'status', 'quantity_count', 'selisih', 'waktu_datang', 'warehouse'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'created_at', 'no_Po', 'warehouse', 'driver', 'foto', 'tandatangan', null, 'quantity_item', 'quantity_count', 'selisih', null, null, null);
    protected $column_search    = array('created_at', 'no_Po', 'warehouse', 'driver', 'foto', 'tandatangan', 'quantity_item', 'quantity_count', 'selisih');
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
            $query = $this->dt->where('warehouse', $warehouse)->get();
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

    //datatables akhir

    public function add($data)
    {
        $this->db->table('tbl_po')->insert($data);
    }
    function tampilDataTransaksi()
    {
        return $this->table('tbl_po')->get();
    }
    public function buatPo()
    {
        $kode = $this->db->table('tbl_po')->select('RIGHT(no_Po,3) as no_Po', false)->orderBy('no_Po', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['no_Po']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['no_Po']) + 1;
        }

        $tgl = date('ymd');
        $awal = "PO";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $noManifest = $awal . $l . $tgl . $batas;
        return $noManifest;
    }
}
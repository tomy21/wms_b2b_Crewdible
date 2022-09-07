<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{
    protected $table            = 'tb_user';
    protected $primaryKey       = 'id_user';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'nama', 'email', 'password', 'level'
    ];

    public function buatID()
    {
        $kode = $this->db->table('tb_user')->select('RIGHT(id_user,3) as users', false)->orderBy('id_user', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['users']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['users']) + 1;
        }

        $tgl = date('Ymd');
        $batas = str_pad($no, 7, "0", STR_PAD_LEFT);
        $idUsers = $tgl . $batas;
        return $idUsers;
    }
    public function tampilData()
    {
        return $this->table('tb_user')->get();
    }
    // public function cekUser($email, $password)
    // {
    //     return $this->table('tb_user')->where(array('email' => $email, 'password' => $password))->get()->getRowArray();
    // }
}
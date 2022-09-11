<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUsers;

class Users extends BaseController
{
    public function index()
    {
        // $modelUsers = new \Myth\Auth\Models\UserModel();

        // $data = ['data' => $modelUsers->findAll()];

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userId, username, email, foto, name, active');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();

        $data = ['data' => $query->getResultArray()];

        return view('Users/index', $data);
    }
    function modalTambah()
    {
        if ($this->request->isAJAX()) {
            $modelUsers = new ModelUsers();

            $data = $modelUsers->idKaryawan();

            return view('Users/modalTambah', ['id_user' => $data]);
        }
    }
    public function tambahUsers()
    {
        $users          = $this->request->getVar('users');
        $nama           = $this->request->getVar('nama');
        $pass           = password_hash($this->request->getVar('pass'), PASSWORD_BCRYPT);
        $level          = $this->request->getVar('level');
        $warehouse      = $this->request->getVar('warehouse');

        $validation = \Config\Services::validation();
        $validate = $this->validate([
            'users' => [
                'rules' => 'required|is_unique[tbl_karyawan.id_user]',
                'label' => 'Id Users',
                'errors' => [
                    'required'  => '{field} Tidak Boleh Kosong',
                    'is_unique' => "$users sudah digunakan"
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Nama Tidak Boleh Kosong',
                ]
            ],
            'pass' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Password Tidak Boleh Kosong',
                ]
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Level Tidak Boleh Kosong',
                ]
            ],
            'warehouse' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Warehouse Tidak Boleh Kosong',
                ]
            ],
        ]);

        if (!$validate) {
            $error  = [
                'id_user'     => $validation->getError('users'),
                'nama_user'     => $validation->getError('nama'),
                'pass'     => $validation->getError('pass'),
                'level'     => $validation->getError('level'),
                'warehouse'     => $validation->getError('warehouse'),
            ];

            $json = [
                'error'     => $error
            ];
        } else {
            $modelUsers = new ModelUsers();
            $data       = [
                'id_user'           => $users,
                'nama_user'         => $nama,
                'password'          => $pass,
                'level'             => $level,
                'status_kar'             => 1,
                'warehouse'         => $warehouse,
            ];
            $modelUsers->insert($data);

            $json = [
                'success'   => 'Data berhasil ditambah'
            ];
        }
        echo json_encode($json);
    }
    function deleteUser()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('code');
            $modelUsers = new ModelUsers();
            $modelUsers->delete($id);

            $json = [
                'success' => 'Users Berhasil Dihapus...'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function updateData()
    {
        $code = $this->request->getVar('code');
        $modelUsers = new ModelUsers();
        $cekStock   = $modelUsers->find($code);


        $data       = [
            'id_user'       => $code,
            'name'     => $cekStock['nama_user'],
            'level'         => $cekStock['level'],
            'password'      => $cekStock['password'],
            'email'      => $cekStock['warehouse'],
            'status'        => $cekStock['status_kar'],

        ];

        $json = [
            'data'              => view('users/updateUser', $data)
        ];

        echo json_encode($json);
    }
    public function UpdateUser()
    {
        $users          = $this->request->getVar('users');
        $nama           = $this->request->getVar('nama');
        $pass           = password_hash($this->request->getVar('pass'), PASSWORD_BCRYPT);
        $level          = $this->request->getVar('level');
        $status          = $this->request->getVar('status');
        $warehouse          = $this->request->getVar('warehouse');


        $modelUser = new ModelUsers();
        $modelUser->update($users, [
            'name'         => $nama,
            'password'          => $pass,
            'level'             => $level,
            'status'             => $status,
            'email'             => $warehouse,
        ]);


        $json = [
            'success'   => 'Data berhasil diupdate'
        ];

        echo json_encode($json);
    }
    public function UpdateStatus()
    {
        $users          = $this->request->getVar('users');
        $modelUser      = new ModelUsers();
        $rowUser        = $modelUser->find($users);

        $userAktif      = $rowUser['status_kar'];
        if ($userAktif == '1') {
            $modelUser->update($users, [
                'status'    => '0'
            ]);
        } else {
            $modelUser->update($users, [
                'status'    => '1'
            ]);
        }
        $json = [
            'success'   => ''
        ];

        echo json_encode($json);
    }
}
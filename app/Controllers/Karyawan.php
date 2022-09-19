<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKaryawan;

class Karyawan extends BaseController
{
    public function index()
    {
        $modelKaryawan = new ModelKaryawan();
        $warehouse = user()->warehouse;
        $data = ['data' => $modelKaryawan->tampilData($warehouse)];

        return view('Karyawan/karyawan', $data);
    }
    function modalTambah()
    {
        if ($this->request->isAJAX()) {
            $modalUsers = new ModelKaryawan();
            $data = $modalUsers->idKaryawan();

            return view('Karyawan/modalTambah', ['id' => $data]);
        }
    }
    public function tambahUsers()
    {
        $users          = $this->request->getVar('users');
        $nama           = $this->request->getVar('nama');
        $email          = $this->request->getVar('email');
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
            'email' => [
                'rules' => 'required|is_unique[tbl_karyawan.email]',
                'label' => 'Id Users',
                'errors' => [
                    'required'  => '{field} Tidak Boleh Kosong',
                    'is_unique' => "$email sudah digunakan"
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
                'email'     => $validation->getError('email'),
            ];

            $json = [
                'error'     => $error
            ];
        } else {
            $modelKar = new ModelKaryawan();
            $data       = [
                'id_user'           => $users,
                'nama_user'         => $nama,
                'email'             => $email,
                'password'          => $pass,
                'level'             => $level,
                'status_kar'        => 1,
                'warehouse'         => $warehouse,
            ];
            $modelKar->insert($data);

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
            $modelUser = new ModelKaryawan();
            $modelUser->delete($id);

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
        $modelStock = new ModelKaryawan();
        $cekStock   = $modelStock->find($code);


        $data       = [
            'id_user'       => $code,
            'nama_user'     => $cekStock['nama_user'],
            'level'         => $cekStock['level'],
            'password'      => $cekStock['password'],
            'warehouse'      => $cekStock['warehouse'],
            'status'        => $cekStock['status_kar'],

        ];

        $json = [
            'data'              => view('Karyawan/updateUser', $data)
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


        $modelUser = new ModelKaryawan();
        $modelUser->update($users, [
            'nama_user'         => $nama,
            'password'          => $pass,
            'level'             => $level,
            'status_kar'             => $status,
            'warehouse'             => $warehouse,
        ]);


        $json = [
            'success'   => 'Data berhasil diupdate'
        ];

        echo json_encode($json);
    }
    public function UpdateStatus()
    {
        $users          = $this->request->getVar('users');
        $modelUser      = new ModelKaryawan();
        $rowUser        = $modelUser->find($users);

        $userAktif      = $rowUser['status_kar'];
        if ($userAktif == '1') {
            $modelUser->update($users, [
                'status_kar'    => '0'
            ]);
            $json = [
                'success'   => 'User berhasil di aktikan'
            ];
        } else {
            $modelUser->update($users, [
                'status_kar'    => '1'
            ]);
            $json = [
                'success'   => 'User berhasil di aktikan'
            ];
        }


        echo json_encode($json);
    }
}
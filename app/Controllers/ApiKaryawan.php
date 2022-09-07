<?php

namespace App\Controllers;

use App\Models\ModelKaryawan;
use App\Models\ModelLogin;
use CodeIgniter\API\ResponseTrait;

class ApiKaryawan extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->modelKaryawan = new ModelKaryawan();
    }

    public function index()
    {
        helper(['form']);
        $rules = [
            'email'     => 'required|valid_email',
            'password'  => 'required'
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getError());
        $model = new ModelKaryawan();
        $user   = $model->where("email", $this->request->getVar('email'))->first();
        if (!$user) return $this->failNotFound('Email tidak ditemukan');

        $verify = password_verify($this->request->getVar('password'), $user['password']);
        if (!$verify) return $this->fail('Password salah !');
        $response = [
            "success"   => true,
            "data"      => $user,
        ];
        return $this->respond($response);
    }
    public function create()
    {
    }
}
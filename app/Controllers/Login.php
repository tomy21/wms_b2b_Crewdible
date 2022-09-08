<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLogin;

class Login extends BaseController
{
    protected $format  = 'json';
    public function index()
    {
        $data = [
            'title'  => 'Login',
            'config' => config('Auth'),
        ];
        
        return view('login/index', $data);
    }
    public function cekUser()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('pass');

        // $validation = \Config\Services::validation();
        // $valid = $this->validate([
        //     'email'    => [
        //         'label'     => 'email',
        //         'rules'     => 'required',
        //         'errors'    => [
        //             'required'  => '{field} tidak boleh kosong',
        //         ]
        //     ],
        //     'pass'    => [
        //         'label'     => 'Password',
        //         'rules'     => 'required',
        //         'errors'    => [
        //             'required'  => '{field} tidak boleh kosong',
        //         ]
        //     ],
        // ]);
        // if (!$valid) {
        //     $sessError = [
        //         'errEmail'     => $validation->getError('email'),
        //         'errPass'       => $validation->getError('pass')
        //     ];
        //     session()->setFlashdata($sessError);
        //     return redirect()->to(site_url('/login/index'));
        // } else {
        //     $modelLogin = new ModelLogin();

        //     $cekUser = $modelLogin->getWhere(['email' => $email])->getResult();
        //     foreach ($cekUser as $row) {
        //         $cekEmail = $row->email;
        //         if ($cekEmail == null) {
        //             $sessError = [
        //                 'errEmail'     => 'Maaf user belum terdaftar'
        //             ];
        //             session()->setFlashdata($sessError);
        //             return redirect()->to(site_url('/login/index'));
        //         } else {
        //             $passUser   = $row->password;

        //             if (password_verify($password, $passUser)) {
        //                 $idLevel = $row->level;
        //                 $simpan_sess = [
        //                     'email'        => $email,
        //                     'namaUser'      => $row->name,
        //                     'usersLevel'    => $idLevel
        //                 ];
        //                 session()->set($simpan_sess);
        //                 return redirect()->to('/main');
        //             } else {
        //                 $sessError = [
        //                     'errPass'     => 'Maaf Password belum terdaftar'
        //                 ];
        //                 session()->setFlashdata($sessError);
        //                 return redirect()->to(site_url('/login/index'));
        //             }
        //         }
        //     }
        // }
    }
    public function keluar()
    {
        session()->destroy();
        return redirect()->to('login/index');
    }
}
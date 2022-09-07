<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

// class FilterSeller implements FilterInterface
// {
//     public function before(RequestInterface $request, $arguments = null)
//     {
//         if(session()->usersLevel == ''){
//             return redirect()->to('/login');
//         }
//     }

//     public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
//     {
//         if(session()->usersLevel == 3){
//             return redirect()->to('/main/index');
//         }
//     }
// }
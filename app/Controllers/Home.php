<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->dhonhit->collect();
    }

    public function index()
    {
        if ($this->key_cookie === null || $this->user_cookie === null) return redirect()->to($this->auth_redirect);

        $this->data['css'] = '
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/fontawesome.min.css">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/bootstrap.min.css">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/templatemo-style.css">
        ';

        return view('home', $this->data);
    }
}

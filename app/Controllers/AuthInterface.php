<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AuthInterface extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $this->data['title']    = 'Login - ' . $this->data['title'];

        return $this->_isLogin() ? redirect()->to(base_url()) : view('auth', $this->data);
    }

    public function register()
    {
        $this->data['title']    = 'Register - ' . $this->data['title'];

        return $this->_isLogin() ? redirect()->to(base_url()) : view('register', $this->data);
    }
}

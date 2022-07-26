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
    }

    public function index()
    {
        $this->data['page'] = 'Dashboard';

        return $this->_isLogin() ? view('home', $this->data) : redirect()->to($this->auth_redirect);
    }

    public function content()
    {
        $this->data['page'] = 'Content';

        return $this->_isLogin() ? view('content', $this->data) : redirect()->to($this->auth_redirect);
    }
}

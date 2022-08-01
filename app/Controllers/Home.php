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
        $this->data['page']     = 'Dashboard';
        $this->data['title']    = $this->data['page'] . ' - ' . $this->data['title'];

        return $this->_isLogin() ? view('home', $this->data) : redirect()->to($this->auth_redirect);
    }

    private function _initWebsite()
    {
        $this->data['websiteList'] = $this->dhonrequest->get("landingpageweb/getAllByUser?id_user={$this->id_user}sort_by=created_at&sort_method=DESC")['data'];
    }

    private function _initElement()
    {
        $this->data['elementList'] = $this->dhonrequest->get("landingpagecontent/getAll?sort_by=contentName&sort_method=ASC")['data'];
    }

    public function content()
    {
        $this->data['page']     = 'Content';
        $this->data['title']    = $this->data['page'] . ' - ' . $this->data['title'];
        $this->data['css']      = $this->data['css'] . '
            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        ';
        $this->_initWebsite();

        return $this->_isLogin() ? view('content', $this->data) : redirect()->to($this->auth_redirect);
    }

    public function website_list()
    {
        $this->_initWebsite();

        return view('website_list', $this->data);
    }

    public function element($webKey)
    {
        $this->data['page']     = 'Content';
        $this->data['title']    = 'Element - ' . $this->data['title'];
        $this->data['css']      = $this->data['css'] . '
            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        ';
        $this->_initElement();

        return $this->_isLogin() ? view('element', $this->data) : redirect()->to($this->auth_redirect);
    }
}

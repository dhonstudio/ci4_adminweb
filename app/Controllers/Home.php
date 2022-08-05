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

    // public function index()
    // {
    //     $this->data['page']     = 'Dashboard';
    //     $this->data['title']    = $this->data['page'] . ' - ' . $this->data['title'];

    //     return $this->_isLogin() ? view('home', $this->data) : redirect()->to($this->auth_redirect);
    // }

    private function _initWebsite()
    {
        $websiteList = $this->user['status'] == '11' ? $this->dhonrequest->get("landingpageweb/getAll?sort_by=created_at&sort_method=DESC")['data'] : $this->dhonrequest->get("landingpageweb/getAllByUser?id_user={$this->id_user}&sort_by=created_at&sort_method=DESC")['data'];

        $this->data['websiteList'] = $websiteList;
    }

    private function _initPage($webKey)
    {
        $this->data['pageList'] = $this->dhonrequest->get("landingpagepage/getAllByKey?webKey={$webKey}&sort_by=pageName&sort_method=ASC")['data'];
    }

    private function _initElement($pageKey)
    {
        $this->data['elementList'] = $this->dhonrequest->get("landingpagecontent/getAllByKey?pageKey={$pageKey}&sort_by=id_content&sort_method=ASC")['data'];
    }

    public function index()
    {
        $this->data['page']     = 'Content';
        $this->data['title']    = $this->data['page'] . ' - ' . $this->data['title'];
        $this->_initWebsite();

        return $this->_isLogin() ? view('content', $this->data) : redirect()->to($this->auth_redirect);
    }

    public function content()
    {
        $this->data['page']     = 'Content';
        $this->data['title']    = $this->data['page'] . ' - ' . $this->data['title'];
        $this->_initWebsite();

        return $this->_isLogin() ? view('content', $this->data) : redirect()->to($this->auth_redirect);
    }

    public function website_list()
    {
        $this->_initWebsite();

        return view('website_list', $this->data);
    }

    public function page($webKey)
    {
        $web = $this->dhonrequest->get("landingpageweb/getByKey?webKey={$webKey}")['data'];

        $this->data['page']     = 'Content';
        $this->data['title']    = $web['webName'] . ' Pages - ' . $this->data['title'];
        $this->data['webName']  = $web['webName'];

        $this->data['webKey']   = $webKey;
        $this->_initPage($webKey);

        return $this->_isLogin() ? view('page', $this->data) : redirect()->to($this->auth_redirect);
    }

    public function page_list($webKey)
    {
        $this->_initPage($webKey);

        return view('page_list', $this->data);
    }

    public function element($webKey, $pageKey)
    {
        $web    = $this->dhonrequest->get("landingpageweb/getByKey?webKey={$webKey}")['data'];
        $page   = $this->dhonrequest->get("landingpagepage/getByKey?pageKey={$pageKey}")['data'];

        $this->data['page']     = 'Content';
        $this->data['title']    = $page['pageName'] . ' ' . $web['webName'] . ' Elements - ' . $this->data['title'];
        $this->data['webName']  = $web['webName'];
        $this->data['pageName'] = $page['pageName'];

        $this->data['webKey']   = $webKey;
        $this->data['pageKey']  = $pageKey;
        $this->_initElement($pageKey);

        return $this->_isLogin() ? view('element', $this->data) : redirect()->to($this->auth_redirect);
    }

    public function element_list($pageKey)
    {
        $this->_initElement($pageKey);

        return view('element_list', $this->data);
    }
}

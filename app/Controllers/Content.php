<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Content extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function add_website()
    {
        $webKey = random_string('alnum', 32);

        $this->dhonrequest->post('landingpageweb/insert', [
            'webKey' => $webKey,
            'webName' => $this->request->getPost('websiteName'),
        ]);
    }

    public function edit_content()
    {
        $key = $this->request->getPost('key') - 1;

        $content = $this->dhonrequest->get("landingpagecontent/getAll")['data'][$key];

        $this->dhonrequest->post('landingpagecontent/edit', [
            'id_content' => $content['id_content'],
            'webKey' => $content['webKey'],
            'contentName' => $content['contentName'],
            'contentValue' => $this->request->getPost('contentValue'),
        ]);
    }
}

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

        return $this->dhonrequest->post('landingpagecontent/edit', [
            'id_content' => $content['id_content'],
            'pageKey' => $content['pageKey'],
            'contentName' => $content['contentName'],
            'contentValue' => $this->request->getPost('contentValue'),
        ]);
    }

    public function upload_content()
    {
        $validationRule = [
            'pictureFile' => [
                'label' => 'Image File',
                'rules' => 'uploaded[pictureFile]'
                    . '|is_image[pictureFile]'
                    . '|mime_in[pictureFile,' . $this->request->getPost('accept') . ']'
                    . '|max_size[pictureFile,1000]',
                // . '|max_dims[pictureFile,1024,768]',
            ],
        ];
        if (!$this->validate($validationRule)) {
            print_r($this->validator->getErrors());
            die;
        }

        $img        = $this->request->getFile('pictureFile');
        $img_ext    = $img->getClientExtension();

        if (!$img->hasMoved()) {
            $key = $this->request->getPost('key') - 1;

            $content    = $this->dhonrequest->get("landingpagecontent/getAll")['data'][$key];
            $filename   = str_replace($img_ext, "", $content['contentValue']);

            $img->move('uploads/' . $content['pageKey'] . '/', $filename . $img_ext, true);

            return redirect()->to($_SERVER['HTTP_REFERER']);
        }

        print_r('The file has already been moved.');
        die;
    }
}

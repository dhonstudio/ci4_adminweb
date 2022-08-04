<?php

namespace App\Controllers;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Psr\Log\LoggerInterface;

class Auth extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->dhonrequest->get("webadmin/getUserByUsername?username={$username}")['data'];

        if ($user && $user['status'] > 9 && password_verify($password, $user['password_hash'])) {
            $config         = new \Config\Encryption();
            $config->key    = $this->encryption_key;
            $config->driver = 'OpenSSL';
            $encrypter      = \Config\Services::encrypter($config);
            $auth_key       = $user['auth_key'];
            $auth_key_enc   = $encrypter->encrypt($auth_key);

            $config         = new \Config\Encryption();
            $config->key    = $auth_key;
            $config->driver = 'OpenSSL';
            $encrypter      = \Config\Services::encrypter($config);
            $id_user        = $user['id_user'];
            $id_user_enc    = $encrypter->encrypt($id_user);

            $session_secure = ENVIRONMENT == 'production' ? true : false;

            set_cookie($this->auth_key_session, $auth_key_enc, 365 * 24 * 60 * 60, '', '/', $this->session_prefix, $session_secure, true, Cookie::SAMESITE_LAX);
            set_cookie($this->id_user_session, $id_user_enc, 365 * 24 * 60 * 60, '', '/', $this->session_prefix, $session_secure, true, Cookie::SAMESITE_LAX);

            echo json_encode(['code' => 1, 'message' => 'Login success']);
        } else {
            echo json_encode(['code' => 0, 'message' => 'Login failed']);
        }
    }

    public function register()
    {
        $username   = $this->request->getPost('username');
        $fullName   = $this->request->getPost('fullName');
        $password   = $this->request->getPost('password');
        $password2  = $this->request->getPost('password2');
        $auth_key   = random_string('alnum', 32);

        $user = $this->dhonrequest->get("webadmin/getUserByUsername?username={$username}")['data'];

        if ($password == $password2 && empty($user)) {
            $this->dhonrequest->post("webadmin/insert", [
                "username"  => $username,
                "fullName"  => $fullName,
                "password_hash"  => $password,
                "auth_key"  => $auth_key,
                "status"    => 9
            ]);
            echo json_encode(['code' => 1, 'message' => 'Successfully registered']);
        } else {
            echo json_encode(['code' => 0, 'message' => 'Failed, username is already registered']);
        }
    }

    public function logout()
    {
        delete_cookie($this->session_prefix . $this->auth_key_session);
        delete_cookie($this->session_prefix . $this->id_user_session);

        return redirect()->to($this->auth_redirect)->withCookies();
    }
}

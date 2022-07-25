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

        $this->dhonhit->collect();
    }

    public function index()
    {
        if ($this->key_cookie !== null && $this->user_cookie !== null) return redirect()->to($this->base_url);

        $this->data['title']    = 'Login - ' . $this->data['title'];
        $this->data['css']      = '
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/fontawesome.min.css">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/bootstrap.min.css">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/templatemo-style.css">
        ';
        $this->data['redirect'] = $this->base_url;

        return view('auth', $this->data);
    }

    public function login()
    {
        $redirect = $this->request->getPost('redirect');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->dhonrequest->get("webadmin/getUserByUsername?username={$username}")['data'];
        if (empty($user))
            return redirect()->to($this->base_url . '/auth');
        else {
            $result = password_verify($password, $user['password_hash']);

            if ($result) {
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

                return redirect()->to($redirect)->setCookie(
                    $this->auth_key_session,
                    $auth_key_enc,
                    new DateTime('+52 week'),
                    '',
                    '/',
                    $this->session_prefix,
                    $session_secure,
                    true,
                    Cookie::SAMESITE_LAX
                )->setCookie(
                    $this->user_session,
                    $id_user_enc,
                    new DateTime('+52 week'),
                    '',
                    '/',
                    $this->session_prefix,
                    $session_secure,
                    true,
                    Cookie::SAMESITE_LAX
                );
            } else {
                return redirect()->to($this->base_url . '/auth');
            }
        }
    }

    public function register()
    {
        $this->data['title']    = 'Register - ' . $this->data['title'];
        $this->data['css']      = '
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/fontawesome.min.css">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/bootstrap.min.css">
            <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/templatemo-style.css">
        ';
        $this->data['redirect'] = $this->base_url . '/auth';

        return view('register', $this->data);
    }

    public function add_user()
    {
        helper('text');

        $username   = $this->request->getPost('username');
        $fullName   = $this->request->getPost('fullName');
        $password   = $this->request->getPost('password');
        $password2  = $this->request->getPost('password2');
        $auth_key   = random_string('alnum', 32);

        if ($password != $password2)
            return redirect()->to($this->base_url . '/register');
        else {
            $user = $this->dhonrequest->get("webadmin/getUserByUsername?username={$username}")['data'];
            if (empty($user))
                $result = $this->dhonrequest->post("webadmin/insert", [
                    "username"  => $username,
                    "fullName"  => $fullName,
                    "password_hash"  => $password,
                    "auth_key"  => $auth_key,
                ])['data'];

            return redirect()->to($this->base_url . '/auth');
        }
    }

    public function logout()
    {
        delete_cookie($this->session_prefix . $this->auth_key_session);
        delete_cookie($this->session_prefix . $this->user_session);

        return redirect()->to($this->base_url . '/auth')->withCookies();
    }
}

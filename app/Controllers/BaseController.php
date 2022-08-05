<?php

namespace App\Controllers;

use Assets\Ci4_libraries\DhonHit;
use Assets\Ci4_libraries\DhonRequest;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Assets path.
     *
     * @var string
     */
    protected $assets = 'http://localhost/assets/';

    /**
     * Git assets path.
     *
     * @var string
     */
    protected $git_assets = '/../../../assets/';

    /**
     * API URL.
     *
     * @var string
     */
    protected $api_url = 'http://localhost/ci4_api2/';

    /**
     * API auth if use basic auth.
     *
     * @var string[]
     */
    protected $api_auth = ['admin', 'admin'];

    /**
     * Enabler page hit traffic.
     *
     * @var boolean
     */
    protected $hit_traffic = true;

    /**
     * Auth Key cookie session.
     *
     * @var string
     */
    protected $auth_key_session = 'DSwa4aK';

    /**
     * User cookie session.
     *
     * @var string
     */
    protected $id_user_session = 'DSwa4iU';

    /**
     * Encryption key.
     *
     * @var string
     */
    protected $encryption_key = 'a4jJdsikR9owkIIdslK0OekkdlPaA3eF';

    /**
     * Cookie session prefix.
     *
     * @var string
     */
    protected $session_prefix = ENVIRONMENT == 'production' ? '__Secure-' : '__m-';

    /**
     * Dhon Studio library for connect API.
     * Run `git clone https://github.com/dhonstudio/ci4_libraries.git` in your git assets path.
     *
     * @var DhonRequest
     */
    protected $dhonrequest;

    /**
     * Dhon Studio library for create page hit traffic.
     * Run `git clone https://github.com/dhonstudio/ci4_libraries.git` in your git assets path.
     *
     * @var DhonHit
     */
    protected $dhonhit;

    /**
     * Default data for Views.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Auth redirect URL.
     *
     * @var string
     */
    protected $auth_redirect;

    /**
     * Id user.
     *
     * @var int
     */
    protected $id_user = 0;

    /**
     * User.
     */
    protected $user;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        helper('text');

        helper('form');

        $this->auth_redirect = base_url('auth');

        $this->_initLibraries([
            'dhonrequest_version'   => "1.0.0",
            'dhonhit_version'       => "1.0.0",
        ]);

        $this->_checkCookie("webadmin/getUserById?id_user=");

        $this->data = [
            'lang'      => null, // default is `en`
            'meta'      => [
                'keywords'      => 'dhon studio, dhonstudio, dhonstudio.com',
                'author'        => null,
                'generator'     => null,
                'ogimage'       => $this->assets . 'img/ogimg.jpg',
                'description'   => 'The Web Admin built base on Dhon Studio repository on Github.',
            ],
            'favicon'   => $this->assets . "img/icon.ico",
            'title'     => 'Admin Web by Dhon Studio', // default is `Home`

            'email'         => 'admin@dhonstudio.com',
            'whatsapp'      => '62 877 00 8899 13',
            'whatsapp_link' => 'https://wa.me/6287700889913',
            'github'        => 'https://github.com/dhonstudio',
            'instagram'     => 'https://instagram.com/dhonstudio',

            'css' => '
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
                <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/fontawesome.min.css">
                <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/bootstrap.min.css">
                <link rel="stylesheet" href="' . $this->assets . 'vendor/templatemo_524_product_admin/css/templatemo-style.css">
                <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
            ',
        ];

        $this->_initData();
    }

    /**
     * Initialize additional libraries.
     */
    private function _initLibraries($params)
    {
        require __DIR__ . $this->git_assets . 'ci4_libraries/DhonRequest-' . $params['dhonrequest_version'] . '.php';
        $this->dhonrequest = new DhonRequest([
            'api_url'   => $this->api_url,
            'api_auth'  => $this->api_auth,
        ]);

        if ($this->hit_traffic) {
            require __DIR__ . $this->git_assets . 'ci4_libraries/DhonHit-' . $params['dhonhit_version'] . '.php';
            $this->dhonhit = new DhonHit();

            $this->dhonhit->dhonrequest = $this->dhonrequest;
            $this->dhonhit->collect();
        }
    }

    /**
     * Check cookie session.
     */
    private function _checkCookie(string $api_get_user)
    {
        helper('cookie');

        $this->key_cookie = get_cookie($this->session_prefix . $this->auth_key_session);
        $this->user_cookie = get_cookie($this->session_prefix . $this->id_user_session);

        if ($this->key_cookie && $this->user_cookie) {
            $config         = new \Config\Encryption();
            $config->key    = $this->encryption_key;
            $config->driver = 'OpenSSL';
            $encrypter      = \Config\Services::encrypter($config);

            $auth_key       = $encrypter->decrypt($this->key_cookie);

            $config         = new \Config\Encryption();
            $config->key    = $auth_key;
            $config->driver = 'OpenSSL';
            $encrypter      = \Config\Services::encrypter($config);

            $this->id_user  = $encrypter->decrypt($this->user_cookie);

            $this->user     = $this->dhonrequest->get($api_get_user . $this->id_user)['data'];
        }
    }

    /**
     * Initialize additional data.
     */
    private function _initData()
    {
        $this->data['assets']       = $this->assets;
        $this->data['git_assets']   = $this->git_assets;
        $this->data['id_user']      = $this->id_user;
        $this->data['user']         = $this->user;
    }

    /**
     * Check whether any user logon.
     */
    public function _isLogin()
    {
        return $this->key_cookie !== null && $this->user_cookie !== null;
    }
}

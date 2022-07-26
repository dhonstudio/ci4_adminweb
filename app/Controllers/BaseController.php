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
     * Base URL.
     *
     * @var string
     */
    protected $base_url =
    ENVIRONMENT == 'development' ? 'http://localhost/ci4_webadmin'
        : (ENVIRONMENT == 'testing' ? 'http://dev.dhonstudio.com/ci4/webadmin'
            : (ENVIRONMENT == 'production' ? 'https://dhonstudio.com/ci4/webadmin' : ''));

    /**
     * Assets path.
     *
     * @var string
     */
    protected $assets =
    ENVIRONMENT == 'development' ? 'http://localhost/assets/' // for development assets
        : 'https://domain.com/assets/'; // for testing and production assets in cloud

    /**
     * Git assets path.
     *
     * @var string
     */
    protected $git_assets =
    ENVIRONMENT == 'development' ? '/../../../assets/'
        : (ENVIRONMENT == 'testing' ? '/../../../../../assets/'
            : (ENVIRONMENT == 'production' ? '/../../../../assets/' : ''));

    /**
     * API auth.
     *
     * @var string[]
     */
    protected $api_url = [
        'development'   => 'http://localhost/ci4_api2/',
        'testing'       => 'http://dev.dhonstudio.com/ci4/api2/',
        'production'    => 'https://dhonstudio.com/ci4/api2/',
    ];

    /**
     * API auth.
     *
     * @var string
     */
    protected $api_auth =
    ENVIRONMENT == 'production' ? ['prod_username', 'prod_password'] // for production API
        : ['dev_username', 'dev_password']; // for development and testing API

    /**
     * Enabler/disabler page hit traffic.
     *
     * @var boolean
     */
    protected $hit_traffic = false;

    /**
     * Dhon Studio library for create page hit traffic.
     * Run `git clone https://github.com/dhonstudio/ci4_libraries.git` in your git assets path.
     *
     * @var DhonHit
     */
    protected $dhonhit;

    /**
     * Dhon Studio library for connect API.
     * Run `git clone https://github.com/dhonstudio/ci4_libraries.git` in your git assets path.
     *
     * @var DhonRequest
     */
    protected $dhonrequest;

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
    protected $user_session     = 'DSwa4iU';

    /**
     * Encryption key.
     *
     * @var string
     */
    protected $encryption_key   = 'a4jJdsikR9owkIIdslK0OekkdlPaA3eF';

    /**
     * Cookie session prefix.
     *
     * @var string
     */
    protected $session_prefix = ENVIRONMENT == 'production' ? '__Secure-' : '__m-';

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
     * Auth redirect URL.
     *
     * @var string
     */
    protected $auth_redirect;

    /**
     * Default data for Views.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->auth_redirect    = $this->base_url . "/auth";
        $api_get_user           = "webadmin/getUserById?id_user=";

        $this->_detectHit();
        $this->_checkCookie($api_get_user);

        $this->data = [
            'base_url'  => $this->base_url,
            'assets'    => $this->assets,
            'id_user'   => $this->id_user,
            'user'      => $this->user,

            'lang'      => null, // default is `en`
            'meta'      => [
                'keywords'      => 'dhon studio, dhonstudio, dhonstudio.com',
                'author'        => null,
                'generator'     => null,
                'ogimage'       => $this->assets . 'img/ogimg.jpg',
                'description'   => 'This landing page built base on Dhon Studio repository on Github.',
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
            ',
        ];
    }

    /**
     * Detect page hit traffic.
     */
    private function _detectHit()
    {
        if ($this->hit_traffic) {
            require __DIR__ . $this->git_assets . 'ci4_libraries/DhonHit.php';

            $this->dhonhit = new DhonHit([
                'api_url'   => $this->api_url,
                'auth'      => $this->api_auth,
            ]);
            $this->dhonhit->base_url = $this->base_url;
            $this->dhonhit->collect();

            $this->dhonrequest = $this->dhonhit->dhonrequest;
        } else {
            require __DIR__ . $this->git_assets . 'ci4_libraries/DhonRequest.php';
            $this->dhonrequest          = new DhonRequest();
            $this->dhonrequest->api_url = $this->api_url;
        }
    }

    /**
     * Check cookie session.
     */
    private function _checkCookie(string $api_get_user)
    {
        helper('cookie');

        $this->key_cookie = get_cookie($this->session_prefix . $this->auth_key_session);
        $this->user_cookie = get_cookie($this->session_prefix . $this->user_session);

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
     * Check whether any user logon.
     */
    public function _isLogin()
    {
        return $this->key_cookie !== null && $this->user_cookie !== null;
    }
}

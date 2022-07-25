<?php

namespace App\Controllers;

use Assets\Ci4_libraries\DhonHit;
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
     * baseurl
     *
     * @var string
     */
    protected $base_url = ENVIRONMENT == 'development' ? 'http://localhost/ci4_adminweb'
        : (ENVIRONMENT == 'testing' ? 'http://dev.domain.com/ci4/...' : 'https://domain.com/ci4/...');

    /**
     * auth redirect url
     *
     * @var string
     */
    protected $auth_redirect;

    /**
     * assets path
     *
     * @var string
     */
    protected $assets = ENVIRONMENT == 'development' ? 'http://localhost/assets/' : 'https://domain.com/assets/';

    /**
     * git assets path
     *
     * @var string
     */
    protected $git_assets = ENVIRONMENT == 'development' ? '/../../../assets/'
        : (ENVIRONMENT == 'testing' ? '/../../../../../assets/' : '/../../../../assets/');

    protected $auth_key_session = 'DSaw4aK';
    protected $user_session     = 'DSaw4iU';
    protected $encryption_key   = 'a4jJdsikR9owkIIdslK0OekkdlPaA3eF';
    protected $session_prefix = ENVIRONMENT == 'production' ? '__Secure-' : '__m-';

    /**
     * default data for views
     *
     * @var mixed
     */
    protected $data;

    /**
     * for create hit page
     *
     * @var DhonHit
     */
    protected $dhonhit;

    /**
     * for connect API
     *
     * @var DhonRequest
     */
    protected $dhonrequest;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->data = [
            'base_url'  => $this->base_url,
            'assets'    => $this->assets,

            'lang'      => null,
            'meta'      => [
                'keywords'      => 'dhon studio, dhonstudio, dhonstudio.com',
                'author'        => null,
                'generator'     => null,
                'ogimage'       => null,
                'description'   => 'This landing page built base on Dhon Studio repository on Github.',
            ],
            'favicon'   => $this->assets . "img/icon.ico",
            'title'     => 'Admin Web by Dhon Studio',

            'email'     => 'admin@dhonstudio.com',
            'whatsapp'  => '62 877 00 8899 13',
            'whatsapp_link'  => 'https://wa.me/6287700889913',
            'github'    => 'https://github.com/dhonstudio',
            'instagram' => 'https://instagram.com/dhonstudio',
        ];

        require __DIR__ . $this->git_assets . 'ci4_libraries/DhonHit.php';
        $auth = ENVIRONMENT == 'production' ? ['prod_username', 'prod_password'] : ['dev_username', 'dev_password'];
        $this->dhonhit = new DhonHit([
            'api_url'   => [
                'development'   => 'http://localhost/ci4_api2/',
                'testing'       => 'http://dev.domain.com/ci4/service/',
                'production'    => 'https://domain.com/ci4/service/',
            ],
            'auth'      => $auth,
        ]);
        $this->dhonhit->base_url = $this->base_url;
        $this->dhonrequest = $this->dhonhit->dhonrequest;
        $this->dhonrequest->auth = $auth;

        $this->auth_redirect = ENVIRONMENT == 'development'
            ? "http://localhost/ci4_adminweb/auth"
            : (ENVIRONMENT == 'testing' ? "http://dev.dhonstudio.com/ci4/sso"
                : "https://dhonstudio.com/ci4/sso");

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

            $this->user     = $this->dhonrequest->get("webadmin/getUserById?id_user={$this->id_user}")['data'];
        }
    }
}

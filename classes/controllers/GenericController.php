<?php

namespace Auth0\SDK\Scaffold\Controllers;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\Auth0;
use Auth0\SDK\API\Management;

use Predis\Client;

/**
 * Class GenericController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
abstract class GenericController
{

    /**
     * Instance of Auth0\SDK\Auth0.
     *
     * @var Auth0
     */
    protected $auth0;

    /**
     * Instance of Auth0\SDK\API\Management.
     *
     * @var Management
     */
    protected $management;

    /**
     * Instance of Auth0\SDK\API\Authentication.
     *
     * @var Authentication
     */
    protected $authentication;

    /**
     * Instance of Predis\Client.
     *
     * @var Client
     */
    protected $redis;

    /**
     * URL query parameters.
     *
     * @var array
     */
    protected $vars;

    /**
     * Instance of Mustache_Engine.
     *
     * @var \Mustache_Engine
     */
    protected $mustache;

    /**
     * Template variables to use.
     *
     * @var array
     */
    protected $tpl_vars;

    /**
     * GenericController constructor.
     *
     * @param Auth0          $auth0 Injected Auth0 instance.
     * @param Authentication $a_api Injected Authentication instance.
     * @param Client $redis Injected Predis\Client instance.
     * @param array          $vars  URL query parameters.
     */
    public function __construct(Auth0 $auth0, Authentication $a_api, Client $redis, array $vars)
    {
        $this->auth0      = $auth0;
        $this->authentication = $a_api;
        $this->redis = $redis;
        $this->vars       = $vars;
        $this->mustache   = new \Mustache_Engine(
            [
                'pragmas' => [\Mustache_Engine::PRAGMA_BLOCKS],
                'loader'  => new \Mustache_Loader_FilesystemLoader(DOC_ROOT.'views'),
            ]
        );

        $this->tpl_vars = [
            'base_url'  => BASE_URL,
            'php_ver'   => phpversion(),
            'a0_domain' => AUTH0_DOMAIN,
            'a0_tenant' => AUTH0_TENANT,
            'a0_client_id' => AUTH0_CLIENT_ID,
            'logged_in' => isset($_SESSION['auth0__user']),
        ];
    }

    /**
     * You have one job.
     *
     * @return mixed
     */
    abstract public function handle();

    /**
     * Output a specific template with variables.
     *
     * @param string $name File name.
     * @param array $tpl_vars Page template variables.
     *
     * @return void
     */
    protected function render($name, array $tpl_vars = [])
    {
        if (! empty($tpl_vars)) {
            $this->tpl_vars['page'] = $tpl_vars;
        }

        $this->setHtmlContentType();
        echo $this->mustache->loadTemplate($name)->render($this->tpl_vars);
    }

    /**
     * Generic error rendering if something goes wrong.
     *
     * @param \Exception $e PHP Exception to output.
     *
     * @return void
     */
    protected function renderError(\Exception $e)
    {
        $this->setHtmlContentType();
        $this->tpl_vars['page'] = [
            'title'   => 'Error - Code: '.($e->getCode() ? $e->getCode() : 'Unknown Code'),
            'content' => $e->getMessage(),
        ];
        echo $this->mustache->loadTemplate('page')->render($this->tpl_vars);
    }

    /**
     * @return Management
     */
    protected function callManagementApi()
    {
        if ($this->management instanceof Management) {
            return $this->management;
        }

        $api_token = getenv('AUTH0_MANAGEMENT_API_TOKEN') ?: $this->redis->get('auth0_api_token');

        if (! $api_token) {
            try {
                $response = $this->authentication->client_credentials([
                    'audience' => 'https://' . AUTH0_DOMAIN . '/api/v2/'
                ]);
                $api_token = $response[ 'access_token' ];
                $this->redis->set('auth0_api_token', $api_token);
                $this->redis->expire('auth0_api_token', $response[ 'expires_in' ]);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        $this->management = new Management($api_token, AUTH0_DOMAIN, ['verify' => false]);
        return $this->management;
    }

    /**
     * Set the Content-Type header.
     *
     * @return void
     */
    private function setHtmlContentType()
    {
        header('Content-Type: text/html; charset=utf-8');
    }
}

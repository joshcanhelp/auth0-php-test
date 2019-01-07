<?php

namespace Auth0\SDK\Scaffold\Controllers;

use Auth0\SDK\Auth0;
use Auth0\SDK\API\Management;

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
     * @param Auth0      $auth0 Injected Auth0 instance.
     * @param Management $m_api Injected Management instance.
     * @param array      $vars  URL query parameters.
     */
    public function __construct(Auth0 $auth0, Management $m_api, array $vars)
    {
        $this->auth0      = $auth0;
        $this->management = $m_api;
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
     *
     * @return void
     */
    protected function render($name)
    {
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
     * Set the Content-Type header.
     *
     * @return void
     */
    private function setHtmlContentType()
    {
        header('Content-Type: text/html; charset=utf-8');
    }
}

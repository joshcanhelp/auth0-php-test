<?php

namespace Auth0\SDK\Scaffold\Controllers;

use Auth0\SDK\Auth0;
use Auth0\SDK\API\Management;

abstract class GenericController {

    /**
     * @var Auth0
     */
    protected $auth0;

    /**
     * @var Management
     */
    protected $management;

    /**
     * @var array
     */
    protected $vars;

    /**
     * @var \Mustache_Engine
     */
    protected $mustache;

    /**
     * @var array
     */
    protected $tpl_vars;

    /**
     * GenericController constructor.
     *
     * @param Auth0 $auth0
     * @param Management $m_api
     * @param array $vars
     */
    public function __construct( Auth0 $auth0, Management $m_api, array $vars ) {
        $this->auth0 = $auth0;
        $this->management = $m_api;
        $this->vars = $vars;
        $this->mustache = new \Mustache_Engine([
            'pragmas' => [\Mustache_Engine::PRAGMA_BLOCKS],
            'loader' => new \Mustache_Loader_FilesystemLoader(DOC_ROOT . 'views'),
        ]);

        $this->tpl_vars = [
            'base_url' => BASE_URL,
            'php_ver' => phpversion(),
            'a0_domain' => AUTH0_DOMAIN,
            'logged_in' => isset( $_SESSION['auth0__user'] ),
        ];
    }

    /**
     * You have one job.
     *
     * @return mixed
     */
    abstract public function handle();

    /**
     * @param string $name - File name
     *
     * @return string
     */
    protected function render( $name ) {
        $this->setHtmlContentType();
        echo $this->mustache->loadTemplate($name)->render($this->tpl_vars);
    }

    /**
     * @param \Exception $e - PHP Exception.
     */
    protected function renderError( $e ) {
        $this->setHtmlContentType();
        $this->tpl_vars['page'] = [
            'title' => 'Error - Code: ' . ( $e->getCode() ? $e->getCode() : 'Unknown Code' ),
            'content' => $e->getMessage(),
        ];
        echo $this->mustache->loadTemplate('page')->render($this->tpl_vars);
    }

    private function setHtmlContentType() {
        header("Content-Type: text/html; charset=utf-8");
    }
}

<?php
namespace Auth0\SDK\Scaffold;

use Auth0\SDK\API\Management;

abstract class ApiTestAbstract implements ApiTestInterface
{
  protected $domain = '';
  protected $token = '';
  protected $api;
  protected $title = '';
  protected $params = [];
  protected $data = [];

  /**
   * Call the management API
   */
  abstract protected function call();

  /**
   * Output an item from a returned array of items
   *
   * @param $datum
   *
   * @return string
   */
  abstract protected function renderDataItem( $datum );
  
  /**
   * ApiTestAbstract constructor.
   *
   * @param array $params
   * @param string $title
   */
  public function __construct( $params = [], $title = '' )
  {
    $this->domain = getenv('AUTH0_DOMAIN');
    $this->token = getenv('AUTH0_TOKEN');
    $this->params = $params;
    $this->title = $title;
    $this->api = new Management( $this->token, $this->domain );
    $this->call();
  }

  /**
   * Output the section header
   */
  public function renderTitle()
  {
    printf( '<h2>%s</h2>', ! empty( $this->title ) ? $this->title : __METHOD__ );
  }

  /**
   * Output the data header
   */
  public function renderDataHeader()
  {
    printf(
      '<h3>Found %s</h3>',
      ! empty( $this->data ) ? count( $this->data ) : 'nothing'
    );
  }

  /**
   * Output the data
   */
  public function renderData()
  {
    if ( ! empty( $this->data ) ) {
      echo '<ul>';
      foreach ( $this->data as $datum ) {
        echo $this->renderDataItem( $datum );
      }
      echo '</ul>';
    }
  }

  /**
   * Render all the things
   */
  public function render()
  {
    $this->renderTitle();
    $this->renderDataHeader();
    $this->renderData();
  }
}
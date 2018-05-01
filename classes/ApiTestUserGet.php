<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestUserGet extends ApiTestAbstract
{

  public function call()
  {
    $this->data = $this->api->users->get( $this->params[ 'id' ] );
  }

  protected function renderDataHeader() {}

  protected function renderData() {
      echo  '<pre>' . print_r( $this->data, TRUE ) . '</pre>';
  }

  public function renderDataItem( $datum ) {}
}
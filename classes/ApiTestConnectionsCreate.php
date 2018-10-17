<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestConnectionsGetAll extends ApiTestAbstract
{
    /**
     * @throws \Exception
     */
    public function call()
    {
        $this->data = $this->api->connections->create();
    }
    
    public function renderData()
    {
        echo  '<pre>' . print_r($this->data, true) . '</pre>';
    }

    public function renderDataItem($datum)
    {
        return sprintf(
            '<li><strong>%s%s</strong> - %s - %d clients enabled</li>',
            $datum['name'],
            $datum['name'] !== $datum['strategy'] ? ' [' . $datum['strategy'] . ']' : '',
            $datum['id'],
            count($datum['enabled_clients'])
        );
    }
}

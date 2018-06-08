<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestClientsGetAll extends ApiTestAbstract
{
    /**
     * @throws \Exception
     */
    public function call()
    {
        $fields = isset($this->params['fields']) ? $this->params['fields'] : null;
        $include_fields = isset($this->params['include_fields']) ? $this->params['include_fields'] : null;
        $page = isset($this->params['page']) ? $this->params['page'] : 0;
        $per_page = isset($this->params['per_page']) ? $this->params['per_page'] : null;
        $this->data = $this->api->clients->getAll($fields, $include_fields, null, $page, $per_page);
    }

    protected function renderData()
    {
        if (!empty($this->data)) {
            echo '<div>';
            foreach ($this->data as $datum) {
                echo $this->renderDataItem($datum);
            }
            echo '</div>';
        }
    }
    
    public function renderDataItem($datum)
    {
        $logo_uri = ! empty($datum['logo_uri'])
            ? $datum['logo_uri']
            : 'https://cdn.auth0.com/styleguide/components/1.0.8/media/logos/img/badge.png';

        $client_name = ! empty($datum['name']) ? $datum['name'] : '[No name returned]';

        $client_id = ! empty($datum['client_id']) ? $datum['client_id'] : '[No client_id returned]';

        return sprintf(
            '<p><img src="%s" width="30" style="vertical-align: middle; display: inline-block;">&nbsp;&nbsp;&nbsp;
            <strong>%s</strong> - %s</p>',
            $logo_uri,
            $client_name,
            $client_id
        );
    }
}

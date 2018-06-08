<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestUsersGetAll extends ApiTestAbstract
{

    /**
     * @throws \Exception
     */
    public function call()
    {
        $this->data = $this->api->users->getAll(
            $this->params['params'],
            isset($this->params['fields']) ? $this->params['fields'] : null,
            isset($this->params['include_fields']) ? $this->params['include_fields'] : null,
            isset($this->params['page']) ? $this->params['page'] : null,
            isset($this->params['per_page']) ? $this->params['per_page'] : null
        );
    }

    /**
     * Output no data header
     */
    protected function renderDataHeader()
    {
    }

    protected function renderData()
    {
        if (!empty($this->data)) {
            echo '<div>';
            if (empty($this->params['params']['include_totals'])) {
                printf(
                    '<h3>Found %s</h3>',
                    ! empty($this->data) ? count($this->data) : 'nothing'
                );
                foreach ($this->data as $datum) {
                    echo $this->renderDataItem($datum);
                }
            } else {
                printf(
                    '<h3>Found %s</h3><h4>Start %d</h4><h4>Limit %d</h4><h4>Length %d</h4>',
                    $this->data['total'],
                    $this->data['start'],
                    $this->data['limit'],
                    $this->data['length']
                );
                foreach ($this->data['users'] as $datum) {
                    echo $this->renderDataItem($datum);
                }
            }
            echo '</div>';
        }
        echo '<pre>' . print_r($this->data, true) . '</pre>';
    }
    
    public function renderDataItem($datum)
    {
        return sprintf(
            '<p><img src="%s" width="30">&nbsp;&nbsp;<strong>%s</strong> - %s</p>',
            !empty($datum['picture']) ? $datum['picture'] : 'https://www.gravatar.com/avatar/',
            !empty($datum['name']) ? $datum['name'] : '[Anonymous]',
            $datum['user_id']
        );
    }
}

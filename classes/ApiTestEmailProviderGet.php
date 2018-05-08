<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestEmailProviderGet extends ApiTestAbstract
{

    public function call()
    {
        $this->data = $this->api->emails->getEmailProvider();
    }

    protected function renderDataHeader()
    {
    }

    protected function renderData()
    {
        if (! empty($this->data)) {
            printf(
                '<h3>Have one!</h3><p><strong>%s</strong> %s</p>',
                $this->data['name'],
                $this->data[ 'enabled' ] ? '✓' : '✗'
            );
        } else {
            echo '<h3>No provider found</h3>';
        }
    }

    public function renderDataItem($datum)
    {
    }
}

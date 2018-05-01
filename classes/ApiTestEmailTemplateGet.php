<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestEmailTemplateGet extends ApiTestAbstract
{

    public function call()
    {
        $this->data = $this->api->emailTemplates->get($this->params[ 'templateName' ]);
    }

    protected function renderDataHeader()
    {
    }

    protected function renderData()
    {
        $html = $this->data[ 'body' ];
        unset($this->data[ 'body' ]);
        echo  '<pre>' . print_r($this->data, true) . '</pre>';
        echo '<pre>' . htmlspecialchars($html) . '</pre>';
    }

    public function renderDataItem($datum)
    {
    }
}

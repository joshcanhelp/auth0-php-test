<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestUserSearch extends ApiTestAbstract
{

    public function call()
    {
        $this->data = $this->api->users->search([
        'q' => $this->params[ 'q' ]
        ]);
    }

    public function renderDataItem($datum)
    {
        return sprintf(
            '<li><strong>%s</strong> &lt;%s&gt; - %s</li>',
            !empty($datum['nickname']) ? $datum['nickname'] : $datum['name'],
            $datum['email'],
            $datum['user_id']
        );
    }
}

<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestLogsSearch extends ApiTestAbstract
{
    /**
     * @throws \Exception
     */
    public function call()
    {
        $this->data = $this->api->logs->search($this->params);
    }

    public function renderDataItem($datum)
    {
        return sprintf(
            '<li><strong>%s</strong><br><code>%s</code><p>%s</p></li>',
            $datum['log_id'],
            $datum['date'],
            ! empty( $datum['description'] ) ? strip_tags($datum['description']) : '[no description provided]'
        );
    }
}

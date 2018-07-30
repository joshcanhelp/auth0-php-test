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

    protected function renderData()
    {
        echo  '<pre>' . print_r($this->data, true) . '</pre>';
//        echo  '<pre>' . print_r(json_decode($this->data->getBody()), true) . '</pre>';
//        if (! empty($this->data)) {
//            echo '<ul>';
//            foreach ($this->data as $datum) {
//                echo $this->renderDataItem($datum);
//            }
//            echo '</ul>';
//        }
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

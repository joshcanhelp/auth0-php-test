<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestUserCreate extends ApiTestAbstract
{
    /**
     * @throws \Exception
     */
    protected function call()
    {
        $this->data = $this->api->users->create($this->params);
    }

    /**
     * Output the data header
     */
    protected function renderDataHeader()
    {
    }

    /**
     * Output the data
     */
    protected function renderData()
    {
        echo  '<pre>' . print_r($this->data, true) . '</pre>';
    }

    /**
     * Use renderData to output complete returned data set.
     *
     * @param $datum
     */
    protected function renderDataItem($datum)
    {
    }
}

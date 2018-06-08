<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestUserDelete extends ApiTestAbstract
{
    /**
     * @throws \Exception
     */
    protected function call()
    {
        $this->data = $this->api->users->delete($this->params['id']);
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
        echo  '<pre>User deleted</pre>';
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

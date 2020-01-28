<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class ImportUsersPostTestController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class ImportUsersPostTestController extends GenericController
{
    /**
     * Handle M-API logs output.
     *
     * @return void
     */
    public function handle()
    {

        if (empty($_POST['connection_id'])) {
            $this->doRender('<pre>Missing required connection_id value</pre>');
        }

        if (empty($_FILES) || empty($_FILES['user_import_file'])) {
            $this->doRender('<pre>No file included</pre>');
        }

        if (! empty($_FILES['user_import_file']['error'])) {
            $this->doRender('<pre>File upload error: ' . $_FILES['user_import_file']['error'] . '</pre>');
        }

        $tmp_name = $_FILES['user_import_file']['tmp_name'];

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if ('text/plain' !== $finfo->file($tmp_name)) {
            $this->doRender('<pre>Invalid file format</pre>');
        }

        $file_path = sprintf('./uploads/%s.json', sha1_file($tmp_name));
        move_uploaded_file($tmp_name, $file_path);

        $params = [
            'upsert' => $_POST['upsert'],
            'send_completion_email' => $_POST['send_completion_email'],
            'external_id' => $_POST['external_id'] ?? null,
        ];

        try {
            $response = $this->callManagementApi()->jobs()->importUsers($file_path, $_POST['connection_id'], $params);
            $response = json_encode($response);
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }

        $this->doRender($response);
    }

    private function doRender($content)
    {
        $this->tpl_vars['page'] = [
            'title' => 'Import Users',
            'content' => $content,
        ];

        $this->render('page');
        exit;
    }
}

<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class ImportUsersGetTestController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class ImportUsersGetTestController extends GenericController
{
    /**
     * Handle M-API logs output.
     *
     * @return void
     */
    public function handle()
    {

        $content = '
        <form method="post" enctype="multipart/form-data">
            <p>
                <label for="user_import_file">Choose a user import file</label><br>
                <input type="file" id="user_import_file" name="user_import_file" required>
            </p>
            <p>
                <label for="connection_id">Connection ID</label><br>
                <input type="text" id="connection_id" name="connection_id" required>
            </p>
            <p>
                <input type="checkbox" id="upsert" name="upsert" value="true"> 
                <label for="upsert">Upsert?</label>
            </p>
            <p>
                <input type="checkbox" id="send_completion_email" name="send_completion_email" value="true"> 
                <label for="send_completion_email">Email?</label>
            </p>
            <p>
                <label for="external_id">External ID</label><br>
                <input type="text" id="external_id" name="external_id">
            </p>
            <p>
                <input type="submit" id="user_import_file" value="Send">            
            </p>
        </form>
        ';


        $this->tpl_vars['page'] = [
            'title' => 'Import Users',
            'content' => $content,
        ];

        $this->render('page');
    }
}

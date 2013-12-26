<?php
/**
 * Date: 12/26/13
 */

namespace Prospe\Controller;

use Prospe\Helper\FacebookHelper;

class TestController extends BaseController {

    public function beforeRoute ($f3, $params) {
        parent::beforeRoute($f3, $params);
        // Check if the user is allowed to access this page
        FacebookHelper::checkUser($f3->get('GET.access_token'));
    }

    public function testAction($f3, $params) {
        $facebook = FacebookHelper::getFacebook();
        $access_token = $f3->get('GET.access_token');
        $friends = $facebook->api('/me/friends');
        //echo "<pre>"; var_dump($friends); echo "</pre>";
        require_once('./vendors/AsyncTask.PHP/src/bootstrap.php');
        $taskId = $f3->get('GET.task_id');
        if (!empty($taskId)) {
            $asyncTask = \AsyncTask::get($taskId);
            echo "<pre>"; var_dump($asyncTask); echo "</pre>";
            return;
        }

        $asyncTask = new \AsyncTask();

        $stop = 10;

        // create the fields in the db while in context

        foreach($friends['data'] as $friend) {
            if ($stop == 0)
                break;

            $stop--;

            $asyncTask->addStep(function () {
                sleep(1);
                echo "Hello world";
            });
        }
        // To avoid noise, let's show an image to everyone
        $asyncTask->addStep(function () {
            sleep(30);
        });
        //$asyncTask->autoDelete();
        echo $asyncTask->start();
    }

} 
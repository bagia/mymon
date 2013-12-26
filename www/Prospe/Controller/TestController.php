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
        $asyncTask->addDependency('Facebook', './vendors/Facebook/facebook.php');
        $asyncTask->addDependency('Base', './bootstrap.php');
        $stop = 10;

        // create the fields in the db while in context

        foreach($friends['data'] as $friend) {
            if ($stop == 0)
                break;

            $stop--;

            $asyncTask->addStep(function () use($facebook, $friend) {
//                $facebook->api('/me/feed', 'POST', array(
//                    'link' => 'http://www.nytimes.com/2013/12/27/world/europe/turkey-corruption-scandal.html?hp',
//                    'picture' => 'http://www.example.com/',
//                    'privacy' => json_encode(array('value' => 'CUSTOM', 'allow' => $friend['id']))
//                ));
                $watchdog = new \Prospe\Model\WatchdogModel();
                $watchdog->name = $friend['name'];
                $watchdog->generateRandomImageName();
                $watchdog->user_id = 0;
                $watchdog->save();
            });
        }
        // To avoid noise, let's show an image to everyone
        $asyncTask->addStep(function () use($facebook, $friend) {
//            $facebook->api('/me/feed', 'POST', array(
//                'link' => 'http://www.nytimes.com/2013/12/27/world/europe/turkey-corruption-scandal.html?hp',
//                'privacy' => json_encode(array('value' => 'ALL_FRIENDS'))
//            ));

        });
        $asyncTask->autoDelete();
        echo $asyncTask->start();
    }

} 
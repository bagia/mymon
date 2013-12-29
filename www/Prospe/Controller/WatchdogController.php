<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Controller;

use Prospe\Helper\FacebookHelper;
use Prospe\Helper\JsonHelper;

class WatchdogController extends BaseController {

    public function beforeRoute ($f3, $params) {
        parent::beforeRoute($f3, $params);
        // Check if the user is allowed to access this page
        \Prospe\Helper\FacebookHelper::checkUser();
    }

    protected function getModel() {
        return new \Prospe\Model\WatchdogModel();
    }

    public function watchdogsCount ($f3, $params) {
        $f3->set('count',
            $this->getModel()->count(array(
                    "user_id=?", FacebookHelper::getUserId()
                ))
        );
        echo \View::instance()->render('json/watchdogs/count.php');
    }

    public function watchdogsList ($f3, $params) {
        //TODO: add offset?
        $f3->set('watchdogs',
            $this->getModel()->find(array(
                    "user_id=?", FacebookHelper::getUserId()
                ))
        );
        echo \View::instance()->render('json/watchdogs/list.php');
    }

    public function watchdogsNew ($f3, $params) {
        $watchdog = $this->getModel();
        $watchdog->generateRandomImageName();
        $watchdog->user_id = FacebookHelper::getUserId();
        $watchdog->name = htmlentities($f3->get('POST.name'));
        $notify_user = htmlentities($f3->get('POST.notify_user'));
        if (!empty($notify_user)) {
            $watchdog->notify_user = $notify_user;
        }
        $watchdog->save();
        $f3->set('watchdog', $watchdog);
        echo \View::instance()->render('json/watchdogs/new.php');
    }

    public function watchdogsDelete ($f3, $params) {
        $status = $this->getModel()->erase(array(
            'id=?', $params['watchdog_id'],
            'user_id=?', FacebookHelper::getUserId()
        ));
        $f3->set('status', $status);
        echo \View::instance()->render('json/watchdogs/delete.php');

    }

    public function watchdogsPower($f3, $params) {
        $post = JsonHelper::getPOST();
        $facebook = FacebookHelper::getFacebook();
        $user_id = FacebookHelper::getUserId();
        $friends = FacebookHelper::getFriends();
        $facebook->setExtendedAccessToken();
        $access_token = $facebook->getAccessToken();
        $link = $post->link;
        if (strpos($link, '#') !== FALSE) {
            $link = reset(explode('#', $link));
        }
        $notify_user = (isset($post->notify_user)) ? htmlentities($post->notify_user) : '';
        $image_base = $f3->get('SCHEME').'://'.$f3->get('HOST').':'.$f3->get('PORT').$f3->get('BASE').'/img/';

        require_once('./vendors/AsyncTask.PHP/src/bootstrap.php');
        $asyncTask = new \AsyncTask();
        $asyncTask->addDependency('Facebook', './vendors/Facebook/facebook.php');
        $asyncTask->addDependency('F3', './bootstrap.php');
        $index = 0;
        foreach($friends as $friend) {
            $index++;

            $watchdog = new \Prospe\Model\WatchdogModel();
            $watchdogs = $watchdog->find(array(
                "user_id=? and friend_id=?", FacebookHelper::getUserId(), $friend['id']
            ));
            if (count($watchdogs) > 0) {
                // We already have a watchdog for this user.
                continue;
            }

            $asyncTask->addStep(function () use($index, $access_token, $facebook,
                                                $user_id, $friend, $notify_user,
                                                $link, $image_base) {
                if ($index % 50 == 0) {
                    sleep(5000);
                }

                $watchdog = new \Prospe\Model\WatchdogModel();
                $watchdog->generateRandomImageName();
                $watchdog->user_id = $user_id;
                $watchdog->name = htmlentities($friend['name']);
                $watchdog->fb_app = $facebook->getAppId();
                if (!empty($notify_user)) {
                    $watchdog->notify_user = $notify_user;
                }

                $facebook->setAccessToken($access_token);
                $randomness = urlencode(crc32(mt_rand(0, PHP_INT_MAX)));
                $article = $facebook->api('/me/feed', 'POST', array(
                    'link' => "http://www.example.com/{$randomness}",
                    'picture' => $image_base . $watchdog->image,
                    'privacy' => json_encode(array('value' => 'CUSTOM', 'allow' => $friend['id']))
                ));

                $watchdog->friend_id = $friend['id'];
                $watchdog->fb_article = $article['id'];
                $watchdog->save();

                // Try to work around Facebook throttle detector
                sleep(30);
                sleep(ceil(mt_rand(0,20)));
            });
        } // End foreach friend

        $asyncTask->autoDelete();
        $task_id = $asyncTask->start();

        $f3->set('task_id', $task_id);
        echo \View::instance()->render('json/watchdogs/power.php');
    }

    public function watchdogsPowerTask($f3, $params) {
        $identifier = $params['task_id'];
        require_once('./vendors/AsyncTask.PHP/src/bootstrap.php');
        $asyncTask = \AsyncTask::get($identifier);
        $progress = $asyncTask->getProgress();
        $f3->set('progress', $progress);
        echo \View::instance()->render('json/watchdogs/power_task.php');
    }

    public function watchdogsPowerDelete($f3, $params) {
        $user_id = FacebookHelper::getUserId();
        $facebook = FacebookHelper::getFacebook();
        $facebook->setExtendedAccessToken();
        $access_token = $facebook->getAccessToken();
        $watchdog = $this->getModel();
        $watchdogs = $watchdog->find(array(
            "user_id=? and friend_id IS NOT NULL", FacebookHelper::getUserId()
        ));

        require_once('./vendors/AsyncTask.PHP/src/bootstrap.php');
        $asyncTask = new \AsyncTask();
        $asyncTask->addDependency('Facebook', './vendors/Facebook/facebook.php');
        $asyncTask->addDependency('F3', './bootstrap.php');

        foreach($watchdogs as $watchdog) {
            $watchdog_id = $watchdog->id;
            $asyncTask->addStep(function () use ($facebook, $access_token, $watchdog_id) {
                $watchdog = new \Prospe\Model\WatchdogModel();
                $watchdog->load(array('id=?', $watchdog_id));
                $facebook->setAccessToken($access_token);
                $article = $watchdog->fb_article;
                $response = $facebook->api("/{$article}", 'DELETE');
                if (!isset($response['error'])) {
                    $watchdog->erase();
                }

            });
        }

        $asyncTask->autoDelete();
        $task_id = $asyncTask->start();
        $f3->set('task_id', $task_id);
        echo \View::instance()->render('json/watchdogs/power.php');
    }

}
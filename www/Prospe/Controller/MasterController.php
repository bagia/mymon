<?php
/**
 * Date: 12/4/13
 */

namespace Prospe\Controller;

use Prospe\Helper\FacebookHelper;
use Prospe\Model\HistoryModel;
use Prospe\Model\TaskModel;
use Prospe\Model\WatchdogModel;

class MasterController extends BaseController {
    public function masterAction ($f3) {
        echo \View::instance()->render('master.php');
    }

    public function cleanAction($f3, $params) {
        set_time_limit(3600);

        FacebookHelper::checkUser();
        $watchdog = new WatchdogModel();
        $watchdogs = $watchdog->find(array(
            'user_id=?', FacebookHelper::getUserId()
        ));
        $history = new HistoryModel();
        foreach ($watchdogs as $watchdog) {
            $history->erase(array(
                'watchdog=?', $watchdog->id
            ));
            $watchdog->erase();
        }
        $task = new TaskModel();
        $task->erase(array(
            'user_id=?', FacebookHelper::getUserId()
        ));

        $facebook = FacebookHelper::getFacebook();
        $facebook->destroySession();

        echo \View::instance()->render('clean.php');


    }

}
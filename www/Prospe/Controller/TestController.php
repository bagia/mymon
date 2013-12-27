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
        $friends = $facebook->api('/me/friends');

        foreach($friends['data'] as $friend) {
//            $watchdog = new \Prospe\Model\WatchdogModel();
//            $watchdogs = $watchdog->find(array(
//                "user_id=? and name=?", FacebookHelper::getUserId(), htmlentities($friend['name'])
//            ));
//            if (count($watchdogs) > 0) {
//                $watchdogs[0]->friend_id = $friend['id'];
//                $watchdogs[0]->save();
//            }
        }
    }

} 
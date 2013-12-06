<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Controller;

class WatchdogController extends BaseController {

    public function beforeRoute ($f3, $params) {
        parent::beforeRoute($f3, $params);
        // Check if the user is allowed to access this page
        \Prospe\Helper\FacebookHelper::checkUser($f3->get('GET.access_token'), $params['user_third_party_id']);
    }

    protected function getModel() {
        return new \Prospe\Model\WatchdogModel();
    }

    public function watchdogsCount ($f3, $params) {
        $f3->set('count',
            $this->getModel()->count(array(
                    "user_third_party_id=?", $params['user_third_party_id']
                ))
        );
        echo \View::instance()->render('json/watchdogs/count.php');
    }

    public function watchdogsList ($f3, $params) {
        //TODO: add offset?
        $f3->set('watchdogs',
            $this->getModel()->find(array(
                    "user_third_party_id=?", $params['user_third_party_id']
                ))
        );
        echo \View::instance()->render('json/watchdogs/list.php');
    }

    public function watchdogsNew ($f3, $params) {
        $watchdog = $this->getModel();
        $watchdog->generateRandomImageName();
        $watchdog->user_third_party_id = $params['user_third_party_id'];
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
            'user_third_party_id=?', $params['user_third_party_id']
        ));
        $f3->set('status', $status);
        echo \View::instance()->render('json/watchdogs/delete.php');

    }

}
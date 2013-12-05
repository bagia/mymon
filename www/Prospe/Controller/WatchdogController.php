<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Controller;

class WatchdogController {

    public function beforeRoute ($f3, $params) {
        // Check if the user is allowed to access this page
        \Prospe\Helper\FacebookHelper::checkUser($f3->get('GET.access_token'), $params['user_third_party_id']);
    }

    public function afterRoute ($f3) {

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

}
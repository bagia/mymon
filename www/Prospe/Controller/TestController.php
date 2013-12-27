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


        }
    }

} 
<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Helper;

class FacebookHelper {

    protected static $_user_id;

    public static function getFacebook() {
        $f3 = \Base::instance();
        require_once('./vendors/Facebook/facebook.php');
        return new \Facebook(array(
            'appId' => $f3->get('FACEBOOK_APPID'),
            'secret' => $f3->get('FACEBOOK_APPSECRET'),
        ));
    }

    public static function checkUser($access_token) {
        // Check if the user is allowed to access this page
        $facebook = self::getFacebook();
        $facebook->setAccessToken($access_token);
        $me = $facebook->api('/me?fields=id');
        // TODO: add a super user capability?
        if (!isset($me['id']) || $me['id'] == 0) {
            \Base::instance()->error(403);
        } else {
            self::$_user_id = $me['id'];
        }
    }

    public static function getUserId() {
        if (!isset(self::$_user_id)) {
            $facebook = self::getFacebook();
            $access_token = $facebook->getAccessToken();
            if (empty($access_token))
                $facebook->setAccessToken(\Base::instance()->get('GET.access_token'));
            $me = $facebook->api('/me?fields=id');
            self::$_user_id = $me['id'];
        }

        return self::$_user_id;
    }
}
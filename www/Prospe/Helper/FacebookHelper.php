<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Helper;

class FacebookHelper {

    public static function getFacebook() {
        $f3 = \Base::instance();
        require_once('./vendors/Facebook/facebook.php');
        return new \Facebook(array(
            'appId' => $f3->get('FACEBOOK_APPID'),
            'secret' => $f3->get('FACEBOOK_APPSECRET'),
        ));
    }

    public static function checkUser($access_token, $claimed_third_party_id) {
        // Check if the user is allowed to access this page
        $facebook = self::getFacebook();
        $facebook->setAccessToken($access_token);
        $me = $facebook->api('/me?fields=third_party_id');
        // TODO: add a super user capability?
        if ($me['third_party_id'] != $claimed_third_party_id ) {
            \Base::instance()->error(403);
        }
    }
}
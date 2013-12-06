<?php
/**
 * Date: 12/6/13
 */

namespace Prospe\Helper;

class HttpAuthHelper {

    private static $realm = 'Restricted area';

    public static function Authenticate() {
        $f3 = \Base::instance();
        $auth_digest = $f3->get('SERVER.PHP_AUTH_DIGEST');
        if (empty($auth_digest)) {
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Digest realm="'. self::$realm .'",qop="auth",nonce="'. uniqid() .'",opaque="'. md5(self::$realm) .'"');
            die('Unauthorized');
        }

        if (!($data = self::http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) || $data['username'] != $f3->get('HTTP_USER')) {
            $f3->error(401);
        }

        $A1 = md5($data['username'] . ':' . self::$realm . ':' . $f3->get('HTTP_PASS'));
        $A2 = md5($f3->get('SERVER.REQUEST_METHOD').':'.$data['uri']);
        $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

        if ($data['response'] != $valid_response) {
            $f3->error(401);
        }
    }

    private static function http_digest_parse($txt)
    {
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }
}
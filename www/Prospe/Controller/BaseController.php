<?php
/**
 * Date: 12/6/13
 */

namespace Prospe\Controller;

class BaseController {
    public function beforeRoute($f3, $params) {
        \Prospe\Helper\HttpAuthHelper::Authenticate();
    }

    public function afterRoute($f3, $params) {

    }
}
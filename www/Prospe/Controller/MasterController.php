<?php
/**
 * Date: 12/4/13
 */

namespace Prospe\Controller;

class MasterController {

    public function beforeRoute ($f3) {

    }

    public function afterRoute ($f3) {

    }

    public function masterAction ($f3) {
        echo \View::instance()->render('master.php');
    }

}
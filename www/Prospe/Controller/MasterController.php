<?php
/**
 * Date: 12/4/13
 */

namespace Prospe\Controller;

class MasterController extends BaseController {
    public function masterAction ($f3) {
        echo \View::instance()->render('master.php');
    }

}
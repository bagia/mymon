<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Controller;

class JavascriptController extends BaseController {
    public function getScript($f3, $params) {
        $script_file = "/js/{$params['script_name']}.js";
        if (!file_exists($f3->get('UI') . $script_file)) {
            $script_file .= '.php';
            if (!file_exists($f3->get('UI') . $script_file)) {
                $f3->error(404);
                return;
            }
        }

        echo \View::instance()->render($script_file);
    }
}
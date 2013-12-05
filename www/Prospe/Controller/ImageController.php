<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Controller;

class ImageController {
    public function beforeRoute($f3) {

    }

    public function afterRoute($f3) {

    }

    public function hit($f3, $params) {
        // Get the associated Watchdog
        $watchdogModel = new \Prospe\Model\WatchdogModel();
        $watchdog = $watchdogModel->load(array(
           'image=?', $params['image']
        ));

        if ($watchdog) {
            // The image belongs to a genuine watchdog.
            // Let's add a history entry.
            $history = new \Prospe\Model\HistoryModel();
            $history->watchdog = $watchdog->id;
            $history->user_agent = $f3->get('SERVER.HTTP_USER_AGENT');
            $history->save();

            if (!empty($watchdog->notify_user)) {
                $facebook = \Prospe\Helper\FacebookHelper::getFacebook();
                $facebook->api( "/{$watchdog->notify_user}/notifications",
                    "POST",
                    array (
                        'access_token' => $facebook->getApplicationAccessToken(),
                        'template' => "Watchdog \"{$watchdog->name}\" was triggered.",
                        'href' => '/#/watchdogs'
                    )
                );
            }
        }

        $f3->error(404);
    }
}
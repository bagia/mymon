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
            $now = new \DateTime();

            // We need to check whether there already is a history
            // entry that is less than 2 seconds old.
            if (count($watchdog->history) > 0) {
                $last = new \DateTime($watchdog->history[0]->date);
                if ($now->diff($last)->s <= 2) {
                    $f3->error(404);
                    return;
                }
            }

            // Let's add a history entry.
            $history = new \Prospe\Model\HistoryModel();
            $history->watchdog = $watchdog->id;
            $history->date = $now->format('Y-m-d H:i:s');
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
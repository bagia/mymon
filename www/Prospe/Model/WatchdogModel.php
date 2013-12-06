<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Model;

class WatchdogModel extends \DB\SQL\Mapper {
    private $dynamic_properties = array();

    public function __construct() {
        parent::__construct( \Base::instance()->get('DB'), 'watchdog' );

        $this->dynamic_properties['history_count'] = 'getHistoryCount';
        $this->dynamic_properties['history'] = 'getHistory';
    }

    public function __get($key) {
        if (array_key_exists($key, $this->dynamic_properties)) {
            return $this->{$this->dynamic_properties[$key]}();
        }

        return parent::__get($key);
    }

    public function generateRandomImageName() {
        $random = md5(uniqid('mymon', TRUE));
        $this->image = "{$random}.png";
    }

    public function getHistoryModel() {
        return new \Prospe\Model\HistoryModel();
    }

    public function getHistoryCount() {
        return $this->getHistoryModel()->count(array(
            'watchdog=?', $this->id
        ));
    }

    public function getHistory($row_count = 10, $offset = 0) {
        return $this->getHistoryModel()->find(array(
            'watchdog=?', $this->id
        ), array(
            'order' => 'date DESC',
            'limit' => $row_count,
            'offset' => $offset
        ));
    }
}
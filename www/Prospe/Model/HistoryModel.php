<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Model;

class HistoryModel extends \DB\SQL\Mapper {
    public function __construct() {
        parent::__construct( \Base::instance()->get('DB'), 'history' );
    }
}
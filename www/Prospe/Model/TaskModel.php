<?php
/**
 * Date: 1/1/14
 */

namespace Prospe\Model;

class TaskModel extends \DB\SQL\Mapper {
    public function __construct() {
        parent::__construct( \Base::instance()->get('DB'), 'task' );
    }
}
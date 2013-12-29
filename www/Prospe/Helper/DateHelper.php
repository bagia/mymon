<?php
/**
 * Date: 12/28/13
 */

namespace Prospe\Helper;


class DateHelper {

    public static function diff(\DateTime $d1, \DateTime $d2) {
        return $d1->getTimestamp() - $d2->getTimestamp();
    }
} 
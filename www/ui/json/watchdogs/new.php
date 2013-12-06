<?php
echo \Prospe\Helper\JsonHelper::encodeFieldsOfObject(array(
    'id', 'image', 'name', 'notify_user'
), $watchdog);
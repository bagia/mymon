<?php
    echo \Prospe\Helper\JsonHelper::encodeFieldsOfArrayOfObjects(array(
        'id', 'image', 'name', 'history_count', 'history' => array('id', 'date', 'user_agent')
    ), $watchdogs);
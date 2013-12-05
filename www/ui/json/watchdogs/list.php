<?php
    echo \Prospe\Helper\JsonHelper::encodeFieldsOfArrayOfObjects(array(
        'id', 'image', 'name', 'history_count', 'history[id,date]'
    ), $watchdogs);
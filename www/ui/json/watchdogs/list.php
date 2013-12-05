<?php
    echo \Prospe\Helper\JsonHelper::encodeFieldsOfArrayOfObjects(array(
        'id', 'image', 'name'
    ), $watchdogs);
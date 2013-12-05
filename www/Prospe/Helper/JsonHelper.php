<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Helper;

class JsonHelper {
    public static function bundleFieldsOfObject(array $fields, $object) {
        $lightObject = new \stdClass();
        foreach($fields as $field) {
            $lightObject->{$field} = $object->{$field};
        }
        return $lightObject;
    }

    public static function encodeFieldsOfObject(array $fields, $object) {
        return json_encode(self::bundleFieldsOfObject($fields, $object));
    }

    public static function bundleFieldsOfArrayOfObjects(array $fields, array $objects) {
        $lightArray = array();
        foreach($objects as $object) {
            $lightArray[] = self::bundleFieldsOfObject($fields, $object);
        }
        return $lightArray;
    }

    public static function encodeFieldsOfArrayOfObjects(array $fields, array $objects) {
        return json_encode(self::bundleFieldsOfArrayOfObjects($fields, $objects));
    }

    public static function bundleValue($value) {
        return (object)array('data' => $value);
    }

    public static function encodeValue($value) {
        return json_encode(self::bundleValue($value));
    }
}
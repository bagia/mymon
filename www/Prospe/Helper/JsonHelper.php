<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Helper;

class JsonHelper {
    // Serialization of objects, object members, and array of objects members
    // Example id, member1, array1orobject1[memberA,memberB]
    public static function bundleFieldsOfObject(array $fields, $object) {
        $lightObject = new \stdClass();
        foreach($fields as $field) {
            if (preg_match_all('/[\w]+/', $field, $matches) > 1) {
                // Serializing a sub-object
                $matches = $matches[0];
                $field = reset($matches);
                array_shift($matches);
                // Check if this an array of objects
                if (is_array($object->{$field})) {
                    $lightField = array();
                    foreach($object->{$field} as $k => $v) {
                        $lightField[$k] = self::bundleFieldsOfObject($matches,$v);
                    }
                } else {
                    $lightField = self::bundleFieldsOfObject($matches,$object->{$field});
                }
            } else {
                $lightField = $object->{$field};
            }
            $lightObject->{$field} = $lightField;
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
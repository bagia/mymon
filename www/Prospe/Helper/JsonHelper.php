<?php
/**
 * Date: 12/5/13
 */

namespace Prospe\Helper;

class JsonHelper {
    // Serialization of objects, object members, and array of objects members
    // Example id, member1, member2 => array(sub1, sub2 => array(subsub1, subsub2))
    public static function bundleFieldsOfObject(array $fields, $object) {
        $lightObject = new \stdClass();
        foreach($fields as $key => $field) {
            if (is_array($field)) {
                // Serializing a sub-object
                $sub_fields = $field;
                $field = $key;
                // Check if this an array of objects
                if (is_array($object->{$field})) {
                    $lightField = self::bundleFieldsOfArrayOfObjects($sub_fields, $object->{$field});
                } else {
                    $lightField = self::bundleFieldsOfObject($sub_fields,$object->{$field});
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
        foreach($objects as $key => $object) {
            $lightArray[$key] = self::bundleFieldsOfObject($fields, $object);
        }
        return $lightArray;
    }

    public static function encodeFieldsOfArrayOfObjects(array $fields, array $objects) {
        return json_encode(self::bundleFieldsOfArrayOfObjects($fields, $objects));
    }

    public static function bundleValue($value, $name = 'data') {
        return (object)array($name => $value);
    }

    public static function encodeValue($value, $name = 'data') {
        return json_encode(self::bundleValue($value, $name));
    }

    public static function getPOST() {
        $json = file_get_contents("php://input");
        return json_decode($json);
    }
}
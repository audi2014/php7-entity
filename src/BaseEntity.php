<?php
/**
 * Created by PhpStorm.
 * User: arturmich
 * Date: 2/18/19
 * Time: 2:45 PM
 */

namespace Audi2014\Entity;
abstract class BaseEntity implements \JsonSerializable {

    protected function getIntIdsKeys() {
        return [];
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return [];
    }

    public function __construct(array $array = []) {
        $this->setState($array ? $array : (array)$this);
    }

    public function setState(array $array, bool $setNull = false): array {
        $diff = [];
        foreach ($this as $key => $value) {
            $a_value = $array[$key] ?? null;
            if ($setNull || $a_value !== null) {
                if (in_array($key, $this->getIntIdsKeys())) {
                    if (is_string($a_value)) {
                        $a_value = empty($a_value) ? [] : explode(',', $a_value);
                    }
                    if (is_array($a_value)) {
                        $a_value = array_map('intval', $a_value);
                        sort($a_value);
                    }
                }
                if ($this->{$key} != $a_value) {
                    $diff[$key] = $a_value;
                }
                $this->{$key} = $a_value;
            }
        }
        return $diff;
    }

    public static function ArrayToEntity(?array $array): ?BaseEntity {
        if ($array === null) return null;
        else return new static($array);
    }

    static function nullableString($v): ?string {
        if ($v === null) return null;
        return self::string($v);
    }

    static function stringOrDefault($v, $default = ''): ?string {
        if ($v === null) return $default;
        return self::string($v);
    }

    static function intOrDefault($v, $default = 0): ?string {
        if ($v === null) return $default;
        return self::int($v);
    }

    static function nullableInt($v): ?int {
        if ($v === null) return null;
        return self::int($v);

    }

    static function nullableBool($v): ?bool {
        if ($v === null) return null;
        return self::bool($v);
    }

    static function nullableArrayOfValues($v, $validate): ?array {
        if ($v === null) return null;
        return self::arrayOfValues($v, $validate);
    }

    static function arrayOfValues($v, $validate): array {
        return array_map($validate, (array)$v);
    }

    static function int($v): int {
        return (int)$v;
    }

    static function bool($v): bool {
        return (bool)$v;
    }

    static function string($v): string {
        return (string)$v;
    }
    static function nullableFloat($v): ?float {
        if ($v === null) return null;
        return (float)$v;
    }
}
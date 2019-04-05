<?php
/**
 * Created by PhpStorm.
 * User: arturmich
 * Date: 2/18/19
 * Time: 2:45 PM
 */

namespace Audi2014\Entity;
abstract class DataEntity {


    public function __construct(array $array = []) {
        foreach ($this as $key => $value) {
            if (isset($array[$key])) {
                $this->{$key} = $array[$key];
            }
        }
    }

}
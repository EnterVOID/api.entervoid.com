<?php

/**
 * Map $callable over the given array. Point is that array_map:
 *   (1) only works on literal arrays, and
 *   (2) doesn't pass the key into the callback.
 *
 * @param $array
 * @param \Closure $callable ($value, $key) => mixed
 *
 * @return array
 */
function map($array, $callable)
{
    if (!$array) {
        return array();
    }

    $result = array();
    foreach ($array as $key => $value) {
        $result[] = $callable($value, $key);
    }

    return $result;
}

/**
 * Construct an associative array by returning pairs ([$key, $value]) for each
 * element of $array
 *
 * @param $array
 * @param \Closure $callable
 *
 * @return array
 */
function zip($array, $callable)
{
    if (!$array) {
        return array();
    }

    $zipped = array();
    foreach ($array as $key => $value) {
        $result = call_user_func($callable, $value, $key, $array);
        if (!is_array($result) || count($result) !== 2) {
            continue;
        }

        list($zKey, $zValue) = $result;
        $zipped[$zKey] = $zValue;
    }

    return $zipped;
}

/**
 * Find the first value in $array that satisfies $predicate.
 *
 * @param $array
 * @param callable $predicate ($item, $arrayKey, $array) => boolean (true if greater)
 *
 * @return mixed|null
 */
function first($array, $predicate = null)
{

    foreach ($array as $key => $value) {
        $result = $predicate
            ? call_user_func($predicate, $value, $key, $array)
            : $value;

        if ($result) {
            return $value;
        }
    }

    return null;
}

function filter($array, $predicate = null)
{
    $result = [];
    $predicate = $predicate ?? function($thing) { return $thing; };

    foreach ($array as $key => $value) {
        if (!call_user_func($predicate, $value, $key, $array)) {
            continue;
        }

        $result[] = $value;
    }

    return $result;
}


<?php

/**
 * @param array $arr
 * @param $key
 *
 * @return mixed|null
 */
function array_value( array $arr, $key ) {
    return isset( $arr[$key] ) ? $arr[$key] : null;
}

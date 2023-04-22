<?php

function get_nested_array_values($array, $values = [])
{
    foreach ($array as $k => $value) {

        if (!is_array($value)) {
            $values[] = $value;
        } else {
            $values =  get_nested_array_values($value, $values);
        }
    }

    return $values;
}


function random_string($length = 5)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

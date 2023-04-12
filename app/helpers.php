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

 
<?php
    function array2hash($array) {
        $result = [];
        foreach ($array as $subArray) {
            $name = $subArray[0];
            $age = $subArray[1];
            $result[$age] = $name;
        }
        return $result;
    }


<?php
    function array2hash_sorted($array) {
        $result = [];
        foreach ($array as $subArray) {
            $name = $subArray[0];
            $age = $subArray[1];
            $result[$name] = $age;
        }
        krsort($result);
        return $result;
    }
?>

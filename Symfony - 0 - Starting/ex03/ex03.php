<?php
    include('./array2hash_sorted.php');

    $array = array(
        array("Pierre", "30"),
        array("Mary", "28"),
        array("Jean", "26"),
        array("Morganne", "12"),
    );

    print_r(array2hash_sorted($array));
?>

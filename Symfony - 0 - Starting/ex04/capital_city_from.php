<?php
    $states = [
        'Oregon' => 'OR',
        'Alabama' => 'AL',
        'New Jersey' => 'NJ',
        'Colorado' => 'CO',
    ];

    $capitals = [
        'OR' => 'Salem',
        'AL' => 'Montgomery',
        'NJ' => 'trenton',
        'KS' => 'Topeka',
    ];

    function capital_city_from($state) {
        global $states;
        global $capitals;
    
        if (array_key_exists($state, $states)) {
            $abbreviation = $states[$state];
            return array_key_exists($abbreviation, $capitals) ? $capitals[$abbreviation] . "\n" : "Unknown\n";
        } else {
            return "Unknown\n";
        }
    }
?>
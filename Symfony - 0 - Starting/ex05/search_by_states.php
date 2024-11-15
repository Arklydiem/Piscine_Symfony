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

    function search_by_states($states_to_found) {
        global $states;
        global $capitals;
    
        $locations = explode(',', $states_to_found);
        foreach ($locations as $location) {
            $value = trim($location);
            
            if (array_key_exists($value, $states) && isset($capitals[$states[$value]])) {
                echo $capitals[$states[$value]] . " is the capital of " . $value . ".\n";
            }
            else if (in_array($value, $capitals) && in_array(array_search($value, $capitals), $states)) {
                $stateName = array_search(array_search($value, $capitals), $states);
                echo $value . " is the capital of " . $stateName . ".\n";
            } else {
                echo $value . " is neither a capital nor a state.\n";
            }
        }
    }

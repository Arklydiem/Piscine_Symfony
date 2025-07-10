<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/e08/address/createTable' => [[['_route' => 'address_createTable', '_controller' => 'App\\Controller\\AddressController::createTable'], null, ['GET' => 0], null, false, false, null]],
        '/e08' => [[['_route' => 'home', '_controller' => 'App\\Controller\\AppController::home'], null, ['GET' => 0], null, false, false, null]],
        '/e08/bank_account/createTable' => [[['_route' => 'bank_account_createTable', '_controller' => 'App\\Controller\\BankAccountController::createTable'], null, ['GET' => 0], null, false, false, null]],
        '/e08/person/createTable' => [[['_route' => 'person_createTable', '_controller' => 'App\\Controller\\PersonController::createTablePersons'], null, ['GET' => 0], null, false, false, null]],
        '/e08/person/updateTable' => [[['_route' => 'person_updateTable', '_controller' => 'App\\Controller\\PersonController::updateTablePersons'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

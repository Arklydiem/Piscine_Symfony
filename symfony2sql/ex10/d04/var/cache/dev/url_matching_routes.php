<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/e10' => [[['_route' => 'home_home', '_controller' => 'App\\Controller\\AppController::home'], null, ['GET' => 0], null, false, false, null]],
        '/e10/showTables' => [[['_route' => 'home_tables', '_controller' => 'App\\Controller\\AppController::tables'], null, ['GET' => 0], null, false, false, null]],
        '/e10/readFile' => [[['_route' => 'home_readFile', '_controller' => 'App\\Controller\\AppController::readFile'], null, ['GET' => 0], null, false, false, null]],
        '/e10/saveOrm/createTable' => [[['_route' => 'save_orm_createTable', '_controller' => 'App\\Controller\\SaveOrmController::createTable'], null, ['GET' => 0], null, false, false, null]],
        '/e10/saveSql/createTable' => [[['_route' => 'save_sql_createTable', '_controller' => 'App\\Controller\\SaveSqlController::createTable'], null, ['GET' => 0], null, false, false, null]],
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

<?php

/**/
return [
    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=localhost;dbname=phpmvc_project;",
    'username'        => "root",
    'password'        => "",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "mvcproject_",

    // Display details on what happens
    'verbose' => true,

    // Throw a more verbose exception when failing to connect
    'debug_connect' => 'true',
];



/**
define('DB_PASSWORD', 'u.3]?2gR');
return [
    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=krri14;",
    'username'        => "krri14",
    'password'        => DB_PASSWORD,
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "mvcproject_",

    // Display details on what happens
    'verbose' => false,

    // Throw a more verbose exception when failing to connect
    'debug_connect' => 'false',
];
/**/

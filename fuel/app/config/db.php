<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
    'active' => 'pdo',

    'pdo' => array(
        'type'           => 'pdo',
        'connection'     => array(
            'dsn'        => 'mysql:host=mysql8052.xserver.jp;dbname=step0123_db',
            'username'       => 'step0123_user',
            'password'       => 'rikoharu',
            'persistent'     => false,
            'compress'       => false,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => true,
        'identifier' => '`'
    ),
    'mysqli' => array(
        'type'           => 'mysqli',
        'connection'     => array(
            'hostname' => 'mysql8052.xserver.jp',
            'database' => 'step0123_db',
            'username'       => 'step0123_user',
            'password'       => 'rikoharu',
            'persistent'     => false,
            'compress'       => false,
        ),
        'identifier' => '`',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => false,
        'profiling'    => true,
    ),
);


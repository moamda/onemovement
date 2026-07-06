<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => env('ONEMOVEMENT_DB_SYSTEM_DNS'),
    'username' => env('ONEMOVEMENT_DB_SYSTEM_USERNAME'),
    'password' => env('ONEMOVEMENT_DB_SYSTEM_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

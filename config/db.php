<?php
$db =[
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=kontakt23_yii',
    'username' => 'kontakt23_yii',
    'password' => 'Vergil1993',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
// настройки локальной машины
$path_local = __DIR__ . '/db_local.php';
if(file_exists($path_local)) {
    $db = \yii\helpers\ArrayHelper::merge($db, require $path_local);
}
return $db;

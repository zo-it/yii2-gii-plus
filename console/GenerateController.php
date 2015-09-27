<?php

namespace yii\gii\plus\console;

use yii\console\Controller,
PDO,
Yii;


class GenerateController extends Controller
{

public function actionShowTables()
{
$db = Yii::$app->getDb();
var_dump($db->getIsActive());
$driverName = $db->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
var_dump($driverName);

foreach ($db->createCommand('SHOW TABLES;')->queryAll(PDO::FETCH_NUM) as $row) {
var_dump($row);
}
}

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

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
        $db->open();
        $driverName = $db->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        var_dump($driverName);
        var_dump($db->createCommand('SHOW TABLES;')->queryColumn());
    }

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

<?php

namespace yii\gii\plus\console;

use yii\console\Controller,
    yii\base\NotSupportedException,
    PDO,
    Yii;


class GenerateController extends Controller
{

    protected function getTables()
    {
        $db = Yii::$app->getDb();
        if (!$db->getIsActive()) {
            $db->open();
        }
        switch ($db->pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'mysql':
                $sql = 'SHOW TABLES;';
                break;
            case 'pgsql':
                $sql = 'SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\';';
                break;
            default:
                throw new NotSupportedException;
        }
        return $db->createCommand($sql)->queryColumn();
    }

    public function actionShowTables()
    {
        $this->stdout(print_r($this->getTables(), true));
    }

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

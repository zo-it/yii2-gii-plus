<?php

namespace yii\gii\plus\console;

use yii\console\Controller,
    yii\base\NotSupportedException,
    PDO,
    Yii;


class GenerateController extends Controller
{

    protected function getTableNames()
    {
        $db = Yii::$app->getDb();
        if (!$db->getIsActive()) {
            $db->open();
        }
        switch ($db->pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'mysql':
                $command = $db->createCommand('SHOW TABLES;');
                break;
            case 'pgsql':
                $command = $db->createCommand('SELECT table_name FROM information_schema.tables WHERE table_schema = :table_schema;', [':table_schema' => 'public']);
                break;
            default:
                throw new NotSupportedException;
        }
        return $command->queryColumn();
    }

    public function actionShowTables()
    {
        foreach ($this->getTableNames() as $tableName) {
            $this->stdout($tableName . "\n");
        }
    }

    public function actionShowCommands()
    {
        foreach ($this->getTableNames() as $tableName) {
            $s = [
                './yii gii/base-model \\',
                '--tableName="good" \\',
                '--ns="app\\models\\base" \\',
                '--modelClass="GoodBase" \\',
                '--baseClass="yii\\boost\\db\\ActiveRecord" \\',
                '--generateLabelsFromComments=1 \\',
                '--generateQuery=1 \\',
                '--queryNs="app\\models\\queries\\base" \\',
                '--queryClass="GoodQueryBase" \\',
                '--queryBaseClass="yii\\boost\\db\\ActiveQuery" \\',
                '--interactive=0 \\',
                '--overwrite=1'
            ];
            $this->stdout(implode("\n", $s) . "\n");
        }
    }

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

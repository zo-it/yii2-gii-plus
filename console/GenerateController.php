<?php

namespace yii\gii\plus\console;

use yii\console\Controller,
    yii\base\NotSupportedException,
    yii\base\InvalidParamException,
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
            $this->stdout(implode("\n", $this->getCommand($tableName)) . "\n\n");
        }
    }

    public function actionShowCommand($tableName)
    {
        if (!in_array($tableName, $this->getTableNames())) {
            throw new InvalidParamException;
        }
        $this->stdout(implode("\n", $this->getCommand($tableName)) . "\n\n");
    }

    protected function getCommand($tableName)
    {
        $s = [
            './yii gii/base-model \\',
            '  --tableName="' . $tableName . '" \\',
            '  --ns="app\\models\\base" \\',
            '  --modelClass="GoodBase" \\',
            '  --baseClass="yii\\boost\\db\\ActiveRecord" \\',
            '  --generateLabelsFromComments=1 \\',
            '  --generateQuery=1 \\',
            '  --queryNs="app\\models\\query\\base" \\',
            '  --queryClass="GoodQueryBase" \\',
            '  --queryBaseClass="yii\\boost\\db\\ActiveQuery" \\',
            '  --interactive=0 \\',
            '  --overwrite=1 && \\',
            './yii gii/model \\',
            '  --modelClass="app\\models\\base\\GoodBase" \\',
            '  --newModelClass="app\\models\\Good" \\',
            '  --newQueryClass="app\\models\\query\\GoodQuery" \\',
            '  --interactive=0 \\',
            '  --overwrite=0 && \\',
            './yii gii/base-search \\',
            '  --modelClass="app\\models\\Good" \\',
            '  --searchModelClass="app\\models\\search\\base\\GoodSearchBase" \\',
            '  --interactive=0 \\',
            '  --overwrite=1 && \\',
            './yii gii/search \\',
            '  --modelClass="app\\models\\search\\base\\GoodSearchBase" \\',
            '  --newModelClass="app\\models\\search\\GoodSearch" \\',
            '  --interactive=0 \\',
            '  --overwrite=0'
        ];
        return implode("\n", $s);
    }

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

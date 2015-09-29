<?php

namespace yii\gii\plus\console;

use yii\console\Controller,
    yii\gii\plus\helpers\FormHelper,
    yii\helpers\Inflector,
    yii\base\InvalidParamException,
    Yii;


class GenerateController extends Controller
{

    protected function getCommand($tableName)
    {
        $className = Inflector::classify($tableName);
        $s = [
            './yii gii/base-model \\',
            '  --tableName="' . $tableName . '" \\',
            '  --ns="app\\models\\base" \\',
            '  --modelClass="' . $className . 'Base" \\',
            '  --baseClass="yii\\boost\\db\\ActiveRecord" \\',
            '  --generateLabelsFromComments=1 \\',
            '  --generateQuery=1 \\',
            '  --queryNs="app\\models\\query\\base" \\',
            '  --queryClass="' . $className . 'QueryBase" \\',
            '  --queryBaseClass="yii\\boost\\db\\ActiveQuery" \\',
            '  --interactive=0 \\',
            '  --overwrite=1 && \\',
            './yii gii/model \\',
            '  --modelClass="app\\models\\base\\' . $className . 'Base" \\',
            '  --newModelClass="app\\models\\' . $className . '" \\',
            '  --newQueryClass="app\\models\\query\\' . $className . 'Query" \\',
            '  --interactive=0 \\',
            '  --overwrite=0 && \\',
            './yii gii/base-search \\',
            '  --modelClass="app\\models\\' . $className . '" \\',
            '  --searchModelClass="app\\models\\search\\base\\' . $className . 'SearchBase" \\',
            '  --interactive=0 \\',
            '  --overwrite=1 && \\',
            './yii gii/search \\',
            '  --modelClass="app\\models\\search\\base\\' . $className . 'SearchBase" \\',
            '  --newModelClass="app\\models\\search\\' . $className . 'Search" \\',
            '  --interactive=0 \\',
            '  --overwrite=0'
        ];
        return implode("\n", $s);
    }

    public function actionShowTables()
    {
        foreach (FormHelper::getTableNames() as $tableName) {
            $this->stdout($tableName . "\n");
        }
    }

    public function actionShowCommands()
    {
        foreach (FormHelper::getTableNames() as $tableName) {
            $this->stdout($this->getCommand($tableName) . "\n\n");
        }
    }

    public function actionShowCommand($tableName)
    {
        if (!in_array($tableName, FormHelper::getTableNames())) {
            throw new InvalidParamException;
        }
        $this->stdout($this->getCommand($tableName) . "\n");
    }

    public function actionRunCommands()
    {
        foreach (FormHelper::getTableNames() as $tableName) {
            passthru($this->getCommand($tableName));
        }
    }

    public function actionRunCommand($tableName)
    {
        if (!in_array($tableName, FormHelper::getTableNames())) {
            throw new InvalidParamException;
        }
        passthru($this->getCommand($tableName));
    }

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

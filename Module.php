<?php

namespace yii\gii\plus;

use yii\console\Application as ConsoleApplication,
    yii\gii\Module as YiiGiiModule;


class Module extends YiiGiiModule
{

    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $app->controllerMap[$this->id . '-plus'] = ['class' => 'yii\gii\plus\console\GenerateController'];
        }
        parent::bootstrap($app);
    }

    protected function coreGenerators()
    {
        return array_merge(parent::coreGenerators(), [
            'base-model' => ['class' => 'yii\gii\plus\generators\base\model\Generator'],
            'model' => ['class' => 'yii\gii\plus\generators\model\Generator'],
            'base-search' => ['class' => 'yii\gii\plus\generators\base\search\Generator'],
            'search' => ['class' => 'yii\gii\plus\generators\search\Generator']
        ]);
    }
}

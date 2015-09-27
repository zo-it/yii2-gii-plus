<?php

namespace yii\gii\plus\generators\base\model;

use yii\helpers\Inflector,
    ReflectionClass,
    yii\gii\generators\model\Generator as YiiGiiModelGenerator;


class Generator extends YiiGiiModelGenerator
{

    public $ns = 'app\models\base';
    public $baseClass = 'yii\boost\db\ActiveRecord';
    public $generateLabelsFromComments = true;
    public $generateQuery = true;
    public $queryNs = 'app\models\query\base';
    public $queryBaseClass = 'yii\boost\db\ActiveQuery';
    public $use = 'Yii';

    public function getName()
    {
        return 'Base Model Generator';
    }

    public function defaultTemplate()
    {
        $class = new ReflectionClass('yii\gii\generators\model\Generator');
        return dirname($class->getFileName()) . '/default';
    }

    public function beforeValidate()
    {
        if (is_null($this->modelClass)) {
            $this->modelClass = Inflector::classify($this->tableName) . 'Base';
        }
        if (!is_array($this->use)) {
            $this->use = array_filter(array_map('trim', explode(',', $this->use)), 'strlen');
        }
        return parent::beforeValidate();
    }

    public function render($template, $params = [])
    {
        $useDirective = 'use ' . implode(',' . "\n" . '    ', $this->use) . ';';
        return str_replace('use Yii;', $useDirective, parent::render($template, $params));
    }
}

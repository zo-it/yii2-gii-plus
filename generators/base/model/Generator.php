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
        if (is_null($this->modelClass) || is_null($this->queryClass)) {
            $className = Inflector::classify($this->tableName);
            if (is_null($this->modelClass)) {
                $this->modelClass = $className . 'Base';
            }
            if (is_null($this->queryClass)) {
                $this->queryClass = $className . 'QueryBase';
            }
        }
        if (!is_array($this->use)) {
            $this->use = array_filter(array_map('trim', explode(',', $this->use)), 'strlen');
        }
        return parent::beforeValidate();
    }

    protected function generateRelations()
    {
        $relations = parent::generateRelations();
        if (($this->ns != 'app\models') && array_key_exists($this->tableName, $relations)) {
            $fixRelations = [];
            foreach ($relations[$this->tableName] as $relationName => $relation) {
                list($code, $className, $hasMany) = $relation;
                if ($className == $this->modelClass) {
                    $code = str_replace('(' . $className . '::className()', '(\'app\models\\' . Inflector::id2camel($this->tableName, '_') . '\'', $code);
                    if ($hasMany) {
                        $relationName = Inflector::id2camel(Inflector::pluralize($this->tableName), '_');
                    }
                } else {
                    $this->use[] = 'app\models\\' . $className;
                }
                $fixRelations[$relationName] = [$code, $className, $hasMany];
            }
            $relations[$this->tableName] = $fixRelations;
        }
        return $relations;
    }

    public function render($template, $params = [])
    {
        $use = array_unique($this->use);
        usort($use, function ($use1, $use2) {
            return strcasecmp(preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $use1), preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $use2));
        });
        $useDirective = 'use ' . implode(',' . "\n" . '    ', $use) . ';';
        return str_replace('use Yii;', $useDirective, parent::render($template, $params));
    }
}

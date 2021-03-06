<?php

namespace yii\gii\plus\generators\base\model;

use yii\gii\plus\helpers\Helper,
    yii\helpers\Inflector,
    ReflectionClass,
    Yii,
    yii\gii\generators\model\Generator as YiiGiiModelGenerator;


class Generator extends YiiGiiModelGenerator
{

    public $ns = 'app\models\base';
    public $tableName = null;
    public $modelClass = null;
    public $baseClass = 'yii\boost\db\ActiveRecord';
    public $generateRelations = true;
    public $generateLabelsFromComments = true;
    public $generateQuery = true;
    public $queryNs = 'app\models\query\base';
    public $queryClass = null;
    public $queryBaseClass = 'yii\boost\db\ActiveQuery';

    protected $fileUseMap = [];
    protected $use = ['Yii'];

    public function getName()
    {
        return 'Base Model Generator';
    }

    public function getDescription()
    {
        return 'This generator generates a base ActiveRecord class for the specified database table.';
    }

    public function defaultTemplate()
    {
        $class = new ReflectionClass('yii\gii\generators\model\Generator');
        return dirname($class->getFileName()) . '/default';
    }

    public function beforeValidate()
    {
        if (is_null($this->modelClass) || ($this->generateQuery && is_null($this->queryClass))) {
            $className = Inflector::classify($this->tableName);
            if (is_null($this->modelClass)) {
                $this->modelClass = $className . 'Base';
            }
            if (is_null($this->queryClass)) {
                $this->queryClass = $className . 'QueryBase';
            }
        }
        $nsModelClass = $this->ns . '\\' . $this->modelClass;
        if (class_exists($nsModelClass)) {
            $this->baseClass = get_parent_class($nsModelClass);
            // use
            $modelPath = Yii::getAlias('@' . str_replace('\\', '/', ltrim($nsModelClass, '\\') . '.php'));
            if (is_file($modelPath) && preg_match('~use([^;]+);~', file_get_contents($modelPath), $match)) {
                $use = array_filter(array_map('trim', explode(',', $match[1])), 'strlen');
                foreach ($use as $value) {
                    $this->fileUseMap[preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $value)] = $value;
                }
            }
        }
        if ($this->generateQuery) {
            $queryNsQueryClass = $this->queryNs . '\\' . $this->queryClass;
            if (class_exists($queryNsQueryClass)) {
                $this->queryBaseClass = get_parent_class($queryNsQueryClass);
            }
        }
        return parent::beforeValidate();
    }

    protected function generateRelations()
    {
        $allRelations = parent::generateRelations();
        if (($this->ns != 'app\models') && array_key_exists($this->tableName, $allRelations)) {
            $relations = [];
            foreach ($allRelations[$this->tableName] as $relationName => $relation) {
                list ($code, $className, $hasMany) = $relation;
                if ($className == $this->modelClass) { // itself
                    $className2 = Inflector::classify($this->tableName);
                    $code = str_replace('(' . $className . '::className()', '(\'app\models\\' . $className2 . '\'', $code);
                    if ($hasMany) {
                        $relationName = Inflector::camelize(Inflector::pluralize($this->tableName));
                    } elseif ($relationName == $className) {
                        $relationName = $className2;
                    }
                } else {
                    if (array_key_exists($className, $this->fileUseMap)) {
                        $this->use[] = $this->fileUseMap[$className];
                    } else {
                        $this->use[] = 'app\models\\' . $className;
                    }
                }
                $relations[$relationName] = [$code, $className, $hasMany];
            }
            $allRelations[$this->tableName] = $relations;
        }
        return $allRelations;
    }

    public function render($template, $params = [])
    {
        return str_replace('use Yii;', Helper::getUseDirective($this->use), parent::render($template, $params));
    }
}

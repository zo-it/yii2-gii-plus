<?php

namespace yii\gii\plus\generators\search;

use yii\gii\CodeFile,
    yii\helpers\Inflector,
    yii\helpers\StringHelper,
    Yii,
    yii\gii\generators\crud\Generator as YiiGiiCrudGenerator;


class Generator extends YiiGiiCrudGenerator
{

    public $newModelClass;

    public function getName()
    {
        return 'Search Model Generator';
    }

    public function getDescription()
    {
        return '';
    }

    public function attributes()
    {
        $attributes = array_diff(parent::attributes(), ['controllerClass', 'viewPath', 'baseControllerClass', 'indexWidgetType', 'searchModelClass']);
        return array_merge($attributes, ['newModelClass']);
    }

    public function rules()
    {
        $attributes = $this->attributes();
        $rules = [['newModelClass', 'required']];
        foreach (parent::rules() as $rule) {
            if (!is_array($rule[0])) {
                $rule[0] = [$rule[0]];
            }
            $key = array_search('searchModelClass', $rule[0]);
            if ($key !== false) {
                $rule[0][$key] = 'newModelClass';
            }
            $rule[0] = array_intersect($rule[0], $attributes);
            if (count($rule[0])) {
                $rules[] = $rule;
            }
        }
        return $rules;
    }

    public function requiredTemplates()
    {
        return ['search.php'];
    }

    public function beforeValidate()
    {
        if (is_null($this->newModelClass)) {
            /* @var $modelClass \yii\db\ActiveRecord */
            $modelClass = $this->getModelClass();
            $className = Inflector::classify($modelClass::tableName());
            $this->newModelClass = 'app\models\search\\' . $className . 'Search';
        }
        return parent::beforeValidate();
    }

    public function generate()
    {
        $newModelPath = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->newModelClass, '\\') . '.php'));
        return [new CodeFile($newModelPath, $this->render('search.php'))];
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function getModelNamespace()
    {
        return StringHelper::dirname(ltrim($this->getModelClass(), '\\'));
    }

    public function getModelName()
    {
        return StringHelper::basename($this->getModelClass());
    }

    public function getModelAlias()
    {
        $modelAlias = $this->getModelName();
        if ($modelAlias == $this->getNewModelName()) {
            $modelAlias .= 'Base';
        }
        return $modelAlias;
    }

    public function getNewModelClass()
    {
        return $this->newModelClass;
    }

    public function getNewModelNamespace()
    {
        return StringHelper::dirname(ltrim($this->getNewModelClass(), '\\'));
    }

    public function getNewModelName()
    {
        return StringHelper::basename($this->getNewModelClass());
    }

    public function getModelUseDirective()
    {
        $use = ['yii\base\Model'];
        if ($this->getModelNamespace() != $this->getNewModelNamespace()) {
            $modelAlias = $this->getModelAlias();
            if ($modelAlias == $this->getModelName()) {
                $use[] = $this->getModelClass();
            } else {
                $use[] = $this->getModelClass() . ' as ' . $modelAlias;
            }
        }
        usort($use, function ($use1, $use2) {
            return strcasecmp(preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $use1), preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $use2));
        });
        if (count($use)) {
            $useDirective = 'use ' . implode(',' . "\n" . '    ', $use) . ';';
            return $useDirective . "\n\n";
        } else {
            return '';
        }
    }
}
<?php

namespace yii\gii\plus\generators\base\search;

use yii\gii\CodeFile,
    ReflectionClass,
    Yii,
    yii\gii\generators\crud\Generator as YiiGiiCrudGenerator;


class Generator extends YiiGiiCrudGenerator
{

    public $searchModelClass;

    public function getName()
    {
        return 'Base Search Model Generator';
    }

    public function getDescription()
    {
        return '';
    }

    public function attributes()
    {
        return array_diff(parent::attributes(), ['controllerClass', 'viewPath', 'baseControllerClass', 'indexWidgetType']);
    }

    public function rules()
    {
        $attributes = $this->attributes();
        $rules = [['searchModelClass', 'required']];
        foreach (parent::rules() as $rule) {
            if (!is_array($rule[0])) {
                $rule[0] = [$rule[0]];
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

    public function defaultTemplate()
    {
        $class = new ReflectionClass('yii\gii\generators\crud\Generator');
        return dirname($class->getFileName()) . '/default';
    }

    public function generate()
    {
        $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
        return [new CodeFile($searchModel, $this->render('search.php'))];
    }
}

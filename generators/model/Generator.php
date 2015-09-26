<?php

namespace yii\gii\plus\generators\model;

use yii\gii\CodeFile,
    Yii,
    yii\gii\generators\crud\Generator as YiiGiiCrudGenerator;


class Generator extends YiiGiiCrudGenerator
{

    public $endModelClass;

    public function getName()
    {
        return 'Model Generator';
    }

    public function getDescription()
    {
        return '';
    }

    public function attributes()
    {
        $attributes = array_diff(parent::attributes(), ['controllerClass', 'viewPath', 'baseControllerClass', 'indexWidgetType']);
        $key = array_search('searchModelClass', $attributes);
        if ($key !== false) {
            $attributes[$key] = 'endModelClass';
        }
        return $attributes;
    }

    public function rules()
    {
        $attributes = $this->attributes();
        $rules = [['endModelClass', 'required']];
        foreach (parent::rules() as $rule) {
            if (!is_array($rule[0])) {
                $rule[0] = [$rule[0]];
            }
            $rule[0] = array_intersect($rule[0], $attributes);
            if (count($rule[0])) {
                $key = array_search('searchModelClass', $rule[0]);
                if ($key !== false) {
                    $rule[0][$key] = 'endModelClass';
                }
                $rules[] = $rule;
            }
        }
        return $rules;
    }

    public function requiredTemplates()
    {
        return ['model.php'];
    }

    public function generate()
    {
        $endModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->endModelClass, '\\') . '.php'));
        return [new CodeFile($endModel, $this->render('model.php'))];
    }
}

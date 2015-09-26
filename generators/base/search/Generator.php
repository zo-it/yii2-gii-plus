<?php

namespace yii\gii\plus\generators\base\search;

use yii\gii\generators\crud\Generator as YiiGiiCrudGenerator;


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
        $rules = [['searchModelClass', 'required']];
        foreach (parent::rules() as $rule) {
            $rule[0] = array_diff((array)$rule[0], ['controllerClass', 'viewPath', 'baseControllerClass', 'indexWidgetType']);
            if (count($rule[0])) {
                $rules[] = $rule;
            }
        }
        return $rules;
    }
}

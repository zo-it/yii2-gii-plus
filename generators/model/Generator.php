<?php

namespace yii\gii\plus\generators\model;

use yii\gii\generators\crud\Generator as YiiGiiCrudGenerator;


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
}

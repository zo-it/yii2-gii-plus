<?php

namespace yii\gii\plus\generators\base\model;

use ReflectionClass,
    yii\gii\generators\model\Generator as YiiGiiModelGenerator;


class Generator extends YiiGiiModelGenerator
{

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

    public function generate()
    {
        $this->use = array_filter(array_map('trim', explode(',', $this->use)), 'strlen');
        return parent::generate();
    }

    public function render($template, $params = [])
    {
        $useDirective = 'use ' . implode(',' . "\n" . '    ', $this->use) . ';';
        return str_replace('use Yii;', $useDirective, parent::render($template, $params));
    }
}

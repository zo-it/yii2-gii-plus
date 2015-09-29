<?php

use yii\jui\AutoComplete,
    yii\gii\plus\helpers\FormHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\base\search\Generator */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($generator, 'modelClass')->widget(AutoComplete::classname(), [
    'options' => [
        'class' => 'form-control',
        'onfocus' => 'jQuery(this).autocomplete(\'search\');'
    ],
    'clientOptions' => [
        'source' => FormHelper::getModelClasses(),
        'minLength' => 0
    ]
]);
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

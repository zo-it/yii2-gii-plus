<?php

use yii\jui\AutoComplete,
    yii\gii\plus\helpers\FormHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\base\model\Generator */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($generator, 'tableName')->widget(AutoComplete::classname(), [
    'options' => [
        'class' => 'form-control',
        'onfocus' => 'jQuery(this).autocomplete(\'search\');'
    ],
    'clientOptions' => [
        'source' => FormHelper::getTableNames(),
        'minLength' => 0
    ]
]);
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
echo $form->field($generator, 'generateRelations')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs');
echo $form->field($generator, 'queryClass');
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'use');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

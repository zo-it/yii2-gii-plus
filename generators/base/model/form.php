<?php

use yii\gii\plus\widgets\AutoComplete,
    yii\gii\plus\helpers\FormHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\base\model\Generator */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($generator, 'tableName')->widget(AutoComplete::classname(), ['source' => FormHelper::getTableNames()]);
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'ns')->widget(AutoComplete::classname(), ['source' => ['app\models\base', 'app\models']]);
echo $form->field($generator, 'baseClass')->widget(AutoComplete::classname(), ['source' => ['yii\boost\db\ActiveRecord', 'yii\db\ActiveRecord']]);
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
echo $form->field($generator, 'generateRelations')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs')->widget(AutoComplete::classname(), ['source' => ['app\models\query\base', 'app\models\query', 'app\models']]);
echo $form->field($generator, 'queryClass')->widget(AutoComplete::classname(), ['source' => ['yii\boost\db\ActiveQuery', 'yii\db\ActiveQuery']]);
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'use');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

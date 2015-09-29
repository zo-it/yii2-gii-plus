<?php

/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\base\search\Generator */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

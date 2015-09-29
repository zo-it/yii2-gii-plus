<?php

/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\model\Generator */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'newModelClass');
echo $form->field($generator, 'newQueryClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

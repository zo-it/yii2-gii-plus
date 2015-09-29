<?php

/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\search\Generator */

echo '<?php';
?>


namespace <?php echo $generator->getNewModelNamespace(); ?>;

<?php echo $generator->getUseDirective(); ?>

class <?php echo $generator->getNewModelName(); ?> extends <?php echo $generator->getModelAlias(); ?>

{

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        return Model::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        Model::afterValidate();
    }
}

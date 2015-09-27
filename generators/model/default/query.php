<?php
/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\model\Generator */

$primaryKey = $generator->getPrimaryKey();

echo '<?php';
?>


namespace <?php echo $generator->getNewQueryNamespace(); ?>;

<?php echo $generator->getQueryUseDirective(); ?>

class <?php echo $generator->getNewQueryName(); ?> extends <?php echo $generator->getQueryAlias(); ?>

{

    /*public function init()
    {
        parent::init();
    }*/

    /**
     * @return self
     */
    public function <?php echo $primaryKey[0]; ?>($<?php echo $primaryKey[0]; ?>)
    {
        return $this->andWhere([$this->getAlias() . '.`<?php echo $primaryKey[0]; ?>`' => $<?php echo $primaryKey[0]; ?>]);
    }
}

<?php
/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\model\Generator */

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
    public function id($id)
    {
        return $this->andWhere([$this->getAlias() . '.`id`' => $id]);
    }
}

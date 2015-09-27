<?php
/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\model\Generator */

echo '<?php';
?>


namespace <?php echo $generator->getNewQueryNamespace(); ?>;

<?php echo $generator->getNewQueryUseDirective(); ?>

class <?php echo $generator->getNewQueryName(); ?> extends <?php echo $generator->getQueryName(); ?>

{

    public function init()
    {
        parent::init();
    }

    /**
     * @return self
     */
    public function id($id)
    {
        return $this->andWhere([$this->getAlias() . '.`id`' => $id]);
    }
}

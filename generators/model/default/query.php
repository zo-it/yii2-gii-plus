<?php
/* @var $this yii\web\View */
/* @var $generator yii\gii\plus\generators\model\Generator */

echo '<?php';
?>


namespace <?php echo $generator->getNewQueryNamespace(); ?>;

use Yii;


class <?php echo $generator->getNewQueryName(); ?> extends <?php echo $generator->getQueryName(); ?>

{

    public function init()
    {
        parent::init();
    }
}

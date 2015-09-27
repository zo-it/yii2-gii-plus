<?php

namespace yii\gii\plus\console;

use yii\console\Controller;


class GenerateController extends Controller
{

    public function actionIndex()
    {
        $this->run('/help', ['gii-plus']);
    }
}

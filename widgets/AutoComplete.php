<?php

namespace yii\gii\plus\widgets;

use yii\jui\AutoComplete as YiiJuiAutoComplete;


class AutoComplete extends YiiJuiAutoComplete
{

    public $options = [
        'class' => 'form-control',
        'onfocus' => 'jQuery(this).autocomplete(\'search\');'
    ];
}

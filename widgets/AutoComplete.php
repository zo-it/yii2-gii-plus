<?php

namespace yii\gii\plus\widgets;

use yii\jui\AutoComplete as YiiJuiAutoComplete;


class AutoComplete extends YiiJuiAutoComplete
{

    public $options = [
        'class' => 'form-control',
        'onfocus' => 'jQuery(this).autocomplete(\'search\');'
    ];

    public $source = [];

    public $minLength = 0;

    public function run()
    {
        $this->clientOptions = array_merge($this->clientOptions, [
            'source' => $this->source,
            'minLength' => $this->minLength
        ]);
        parent::run();
    }
}

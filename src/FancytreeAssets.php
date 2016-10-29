<?php

namespace nighthtr\fancytree;

use yii\web\AssetBundle;

class FancytreeAssets extends AssetBundle
{
    public $sourcePath = '@bower/fancytree/dist/';
    public $baseUrl = '@web';
    public $css = [
        'skin-bootstrap/ui.fancytree.css',
    ];
    public $js = [
        'jquery.fancytree-all.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

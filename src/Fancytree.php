<?php

namespace nighthtr\fancytree;

use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Sample:
 *
 * <?php
 * echo \nighthtr\fancytree\Fancytree::widget([
 *     'url' => Url::to(['tree/node']),
 * ]);
 * ?>
 */
class Fancytree extends \yii\base\Widget
{
    public $url;
    public $options = [
        'extensions' => ['dnd', 'edit', 'glyph', 'wide'],
        'checkbox' => true,
        'glyph' => 'glyph_opts',
        'selectMode' => 2,
        'wide' => [
            'iconWidth' => '1em',
            'iconSpacing' => '0.5em',
            'levelOfs' => '1.5em',
        ],
    ];

    public function run()
    {
        $this->options = ArrayHelper::merge($this->options, [
            'dnd' => [
                'focusOnClick' => true,
                'dragStart' => new JsExpression("function(node, data) { return true; }"),
                'dragEnter' => new JsExpression("function(node, data) { return false; }"),
                'dragDrop' => new JsExpression("function(node, data) { data.otherNode.copyTo(node, data.hitMode); }"),
            ],
            'source' => => [
                'url' => $this->url,
                'debugDelay' => 1000,
            ],
            'icon' => new JsExpression("function(event, data) {
                // if( data.node.isFolder() ) {
                //     return 'glyphicon glyphicon-book';
                // }
            }"),
            'lazyLoad' => new JsExpression("function(event, data){
                var node = data.node;
                data.result = {
                    url: '" . $this->url . "',
                    data: { id: node.key },
                    cache: false,
                    debugDelay: 1000
                };
            }"),
        ]);

        echo "<pre>";
        print_r($this->options);
        echo "</pre>";
    }
}

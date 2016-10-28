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
        'dnd' => [
            'focusOnClick' => true,
            'dragStart' => new JsExpression("function(node, data) { return true; }"),
            'dragEnter' => new JsExpression("function(node, data) { return false; }"),
            'dragDrop' => new JsExpression("function(node, data) { data.otherNode.copyTo(node, data.hitMode); }"),
        ],
        'glyph' => 'glyph_opts',
        'selectMode' => 2,
        'source' => [
            'url' => Url::to(['tree/node']),
            'debugDelay' => 1000,
        ],
        'wide' => [
            'iconWidth' => '1em',
            'iconSpacing' => '0.5em',
            'levelOfs' => '1.5em',
        ],
        'icon' => new JsExpression("function(event, data) {
            // if( data.node.isFolder() ) {
            //     return 'glyphicon glyphicon-book';
            // }
        }"),
        'lazyLoad' => new JsExpression("function(event, data){
            var node = data.node;
            data.result = {
                url: '" . Url::to(['tree/node']) . "',
                data: { id: node.key },
                cache: false,
                debugDelay: 1000
            };
        }"),
    ];

    public function run()
    {
        if (!empty($url)) {
            $this->options['source'] = [
                'url' => $url,
                'cache' => true,
                'debugDelay' => 1000,
            ];

            $this->options['lazyLoad'] = new JsExpression("function(event, data) {
                var node = data.node;
                // Load child nodes via ajax GET url?mode=children&parent=1234
                data.result = {
                    url: '" . $url . "',
                    data: { id: node.key },
                    cache: false,
                    debugDelay: 1000
                };
            }");
        }

        echo "<pre>";
        print_r($this->options);
        echo "</pre>";
    }
}

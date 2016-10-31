<?php

namespace nighthtr\fancytree;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
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

    public function init()
    {
        parent::init();

        if (empty($this->url)) {
            $this->url = Url::to(['tree/node']);
        }

        $this->options = ArrayHelper::merge($this->options, [
            'dnd' => [
                'focusOnClick' => true,
                'dragStart' => new JsExpression("function(node, data) { return true; }"),
                'dragEnter' => new JsExpression("function(node, data) { return false; }"),
                'dragDrop' => new JsExpression("function(node, data) { data.otherNode.copyTo(node, data.hitMode); }"),
            ],
            [
                'glyph' => [
                    'map' => [
                        'doc' => 'glyphicon glyphicon-file',
                        'docOpen' => 'glyphicon glyphicon-file',
                        'checkbox' => 'glyphicon glyphicon-unchecked',
                        'checkboxSelected' => 'glyphicon glyphicon-check',
                        'checkboxUnknown' => 'glyphicon glyphicon-share',
                        'dragHelper' => 'glyphicon glyphicon-play',
                        'dropMarker' => 'glyphicon glyphicon-arrow-right',
                        'error' => 'glyphicon glyphicon-warning-sign',
                        'expanderClosed' => 'glyphicon glyphicon-menu-right',
                        'expanderLazy' => 'glyphicon glyphicon-menu-right',
                        'expanderOpen' => 'glyphicon glyphicon-menu-down',
                        'folder' => 'glyphicon glyphicon-folder-close',
                        'folderOpen' => 'glyphicon glyphicon-folder-open',
                        'loading' => 'glyphicon glyphicon-refresh glyphicon-spin'
                    ],
                ],
            ],
            'source' => [
                'url' => $this->url,
                'debugDelay' => 1000,
            ],
            'icon' => new JsExpression("function(event, data) {
                // if( data.node.isFolder() ) {
                //     return 'glyphicon glyphicon-book';
                // }
            }"),
            'lazyLoad' => new JsExpression("function(event, data) {
                var node = data.node;
                data.result = {
                    url: '" . $this->url . "',
                    data: { id: node.key },
                    cache: false,
                    debugDelay: 1000
                };
            }"),
        ]);
    }

    public function run()
    {
        $id = $this->getId();
        $options = Json::htmlEncode($this->options);
        $view = $this->getView();
        FancytreeAssets::register($view);

        $view->registerCss("
            ul.fancytree-container {
                border: none;
            }
            #fancytree {
                padding: 3px 5px;
            }
        ");

        $view->registerJs("jQuery('#$id').fancytree($options);");

        return Html::tag('div', 'test', ['id' => $id]);

        echo "<pre>";
        print_r($this->options);
        echo "</pre>";
    }
}

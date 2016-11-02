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
    public $tagret;
    public $maximumSelectionLength = 5;

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

        if (!empty($this->tagret)) {
            $this->options = ArrayHelper::merge($this->options, [
                'activate' => new JsExpression("function(event, data){
                    data.node.setSelected(!data.node.isSelected());
                }"),
                'beforeSelect' => new JsExpression("function(event, data){
                    if (!data.node.isSelected() && data.tree.getSelectedNodes().length >= {$this->maximumSelectionLength}) {
                        return false;
                    }
                }"),
                'select' => new JsExpression("function(event, data){
                    var options = $('#{$this->tagret}').data('s2-options');
                    var dataArray = [];
                    var selectedArray = [];

                    $.each(data.tree.getSelectedNodes(), function(index, node) {
                        dataArray.push({id: node.key, text: node.title});
                    });
                    $.each(dataArray, function(index, item) {
                        selectedArray.push(item.id);
                    });

                    if (selectedArray.length > {$this->maximumSelectionLength}) {
                        return false;
                    }

                    $('#select2-product-category_ids').select2('data', dataArray);
                    $('#select2-product-category_ids').val(selectedArray).trigger('change');

                    // Object.assign(window[options], {data: dataArray});
                    // console.log(window[options]);

                    // $('#{$this->tagret}').select2('destroy');
                    // $('#{$this->tagret}').show();
                    // $('#{$this->tagret}').select2(window[options]);
                    // $('#{$this->tagret}').val(selectedArray).trigger('change');

                    // $('#{$this->tagret}').select2('data', {id: data.node.key, text: data.node.title});
                    // $('#{$this->tagret}').val(data.node.key).trigger('change');
                }"),
            ]);
        }

        $this->options = ArrayHelper::merge($this->options, [
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
                    'loading' => 'glyphicon glyphicon-refresh glyphicon-spin',
                ],
            ],
            'source' => [
                'url' => $this->url,
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
                    cache: false
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

        return Html::tag('div', '', ['id' => $id]);

        echo "<pre>";
        print_r($this->options);
        echo "</pre>";
    }
}

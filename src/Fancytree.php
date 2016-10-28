<?php

namespace nighthtr\fancytree;

/**
 * Sample:
 *
 * <?php
 * echo \nighthtr\fancytree\Fancytree::widget([
 *     'url' => Url::to(['tree/node'],
 * ]);
 * ?>
 */
class Fancytree extends \yii\base\Widget
{
    public function run()
    {
        return "Hello!";
    }
}

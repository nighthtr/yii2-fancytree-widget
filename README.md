nighthtr/yii2-fancytree
=======================
Yii2 FancyTree widget

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nighthtr/yii2-fancytree-widget "*"
```

or add

```
"nighthtr/yii2-fancytree-widget": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \nighthtr\fancytree\Fancytree::widget([
    'url' => Url::to(['tree/node'],
]); ?>
```
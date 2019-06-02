Yii2 - Material Design Lite 
============================
Material Design Lite for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist lismansihotang/yii2-material-design-lite "*"
```

or add

```
"lismansihotang/yii2-material-design-lite": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \lismansihotang\mdl\widgets\Button::widget(['content' => ['label' => 'Hasil']]); ?>
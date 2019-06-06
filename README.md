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

Asset
-----
Register this asset on your own layout. for any purpose custom you can do it by your self, just see "how to" on : https://getmdl.io/components/index.html

```php
<?php
use lismansihotang\mdl\assets\BaseAsset;
BaseAsset::register($this); 
?>
```

Button
-----
Create your simply button.
```php
<?= \lismansihotang\mdl\src\Button::widget(['content' => ['label' => 'button']]); ?>
```

TextField
-----
Create your simply textfield.

without any model
```php
<?= \lismansihotang\mdl\src\TextField::widget(['name'=>'field-name', 'label'=>'For Label']); ?>
```

with model
```php
<?php $form = ActiveForm::begin([
        'fieldClass' => '\lismansihotang\mdl\src\ActiveField'
    ]); ?>


<?= $form->field($model, 'field', ['template' => '{input}{hint}{error}'])->widget(TextField::className(), [
        'options' => ['type' => 'textfield']
    ]) ?>
```

Checkbox
-----
Create your simply checkbox.

without any model
```php
<?= \lismansihotang\mdl\src\Checkbox::widget(['name' => 'is_ok', 'label' => 'Yes']); ?>
```

with model
```php
<?php $form = ActiveForm::begin([
        'fieldClass' => '\lismansihotang\mdl\src\ActiveField'
    ]); ?>


<?= $form->field($model, 'field', ['template' => '{input}{hint}{error}'])->widget(Checkbox::className(), [
        'options' => ['type' => 'checkbox']
    ]) ?>
```

Radio Button
-----
Create your simply radio.

without any model
```php
<?= \lismansihotang\mdl\src\RadioButton::widget(['name' => 'is_ok', 'label' => 'Yes', 'value'=>'1']); ?>
```

with model
```php
<?php $form = ActiveForm::begin([
        'fieldClass' => '\lismansihotang\mdl\src\ActiveField'
    ]); ?>


<?= $form->field($model, 'field', ['template' => '{input}{hint}{error}'])->widget(RadioButton::className(), [
        'options' => ['type' => 'radio']
    ]) ?>
```

Badge
-----
Create your simply badge.
```php
<?= \lismansihotang\mdl\src\Badge::widget(['type_icon' => true, 'label' => 'account_box', 'options' => ['data-badge' => '2']]); ?>
```

Card
-----
Create your simply card.
```php
<?= \lismansihotang\mdl\src\Card::widget([
    'title' => 'Welcome',
    'image' => Yii::getAlias('@web') . '/images/welcome_card.jpg',
    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sagittis pellentesque lacus eleifend lacinia...',
    'button' => ['label' => 'Get Started','action' => ['site/index'],'icon' => 'event'],
    'menu' => ['icon' => 'share','action' => ['sample/action']],
    'options' => ['type' => Card::TYPE_EVENT]]); ?>
```
<?php

namespace lismansihotang\mdl\assets;

class BaseAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/bower-asset/material-design-lite/';
    public $css = [
        'material.min.css',
        'https://fonts.googleapis.com/icon?family=Material+Icons',
    ];
    public $js = [
        'material.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

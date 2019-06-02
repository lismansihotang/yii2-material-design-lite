<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package Widget/button
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#buttons-section
 */

use yii\helpers\Html;

namespace lismansihotang\mdl\widgets;

class Button extends lismansihotang\mdl\helpers\Widget
{
    public $options;
    public $content;
    public function run()
    {
        array_push($this->options, ['class' => 'mdl-button mdl-js-button mdl-button--raised']);
        return Html::tag($this->content, $this->options);
    }
}

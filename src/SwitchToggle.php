<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package SwitchToggle
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#toggles-section
 */

namespace lismansihotang\mdl\src;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\JsExpression;

class SwitchToggle extends \yii\widgets\InputWidget
{
    /**
     * @var \lismansihotang\mdl\src\ActiveField active input field, which triggers this widget rendering.
     * This field will be automatically filled up in case widget instance is created via [[\yii\widgets\ActiveField::widget()]].
     * @since 2.0.11
     */
    public $field;
    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;
    /**
     * @var string the model attribute that this widget is associated with.
     */
    public $attribute;
    /**
     * @var string the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;
    /**
     * @var string the input value.
     */
    public $value;
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string the type widget.
     */
    public $type = 'checkbox';

    /**
     * @var string the default value.
     */
    public $label = 'Label';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->options['class'] = 'mdl-switch__input';

        $this->view->registerCss('.mdl-switch{margin-bottom: 25px;} .mdl-textfield__error{min-width: 400px;}');
        $this->view->registerJs(new JsExpression('
        $("#' . $this->options['id'] . '").on("focusout", function(){
            $(".field-' . $this->options['id'] . '").find(".mdl-textfield__error").css("visibility","visible");
        });
        var label = $("span.mdl-switch__label").find("label").html();
        $("span.mdl-switch__label").html(label); $("span.mdl-switch__label").find("label").remove();
        '));

        if ($this->hasModel()) {
            echo $this->renderInputHtml($this->type) . Html::tag('span', isset($this->options['label']) ? $this->options['label'] : null, ['class' => 'mdl-switch__label']);
        } else {
            echo Html::beginTag('label', ['class' => 'mdl-switch mdl-js-switch mdl-js-ripple-effect', 'for' => $this->options['id']]);
            echo $this->renderInputHtml($this->type) . Html::tag('span', $this->label, ['class' => 'mdl-switch__label']);
            echo Html::endTag('label');
        }
    }
}

<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package TextField
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#buttons-section
 */

namespace lismansihotang\mdl\src;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\JsExpression;

class TextField extends \yii\widgets\InputWidget
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

    public $type = 'text';

    public function run()
    {

        if (array_key_exists('class', $this->options) === true) {
            $this->options['class'] = 'mdl-textfield__input';
        }

        $this->view->registerCss('.mdl-textfield{width: 100%;} .mdl-textfield__label::after{bottom: 15px!important;}');
        $this->view->registerJs(new JsExpression('$("#' . $this->options['id'] . '").on("focusout", function(){
            $(".field-' . $this->options['id'] . '").find(".mdl-textfield__error").css("visibility","visible");
        });'));
        echo $this->renderInputHtml($this->type) . Html::tag('label', Html::activeLabel($this->model, $this->attribute), ['class' => 'mdl-textfield__label', 'for' => $this->options['id']]);
    }
}

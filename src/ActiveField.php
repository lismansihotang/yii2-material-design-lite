<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package ActiveField
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 */

namespace lismansihotang\mdl\src;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

class ActiveField extends \yii\widgets\ActiveField
{
    public $options = ['class' => 'form-group'];
    /**
     * @var string the template that is used to arrange the label, the input field, the error message and the hint text.
     * The following tokens will be replaced when [[render()]] is called: `{label}`, `{input}`, `{error}` and `{hint}`.
     */
    public $template = "{label}\n{input}\n{hint}\n{error}";
    /**
     * @var array the default options for the input tags. The parameter passed to individual input methods
     * (e.g. [[textInput()]]) will be merged with this property when rendering the input tag.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputOptions = ['class' => 'form-control'];
    /**
     * @var array the default options for the error tags. The parameter passed to [[error()]] will be
     * merged with this property when rendering the error tag.
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *   See also [[\yii\helpers\Html::tag()]].
     * - `encode`: whether to encode the error output. Defaults to `true`.
     *
     * If you set a custom `id` for the error element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $errorOptions = ['class' => 'help-block'];
    /**
     * @var array the default options for the label tags. The parameter passed to [[label()]] will be
     * merged with this property when rendering the label tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $labelOptions = ['class' => 'control-label'];
    /**
     * @var array the default options for the hint tags. The parameter passed to [[hint()]] will be
     * merged with this property when rendering the hint tag.
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *   See also [[\yii\helpers\Html::tag()]].
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $hintOptions = ['class' => 'hint-block'];
    /**
     * @var bool whether to enable client-side data validation.
     * If not set, it will take the value of [[ActiveForm::enableClientValidation]].
     */
    public $enableClientValidation;
    /**
     * @var bool whether to enable AJAX-based data validation.
     * If not set, it will take the value of [[ActiveForm::enableAjaxValidation]].
     */
    public $enableAjaxValidation;
    /**
     * @var bool whether to perform validation when the value of the input field is changed.
     * If not set, it will take the value of [[ActiveForm::validateOnChange]].
     */
    public $validateOnChange;
    /**
     * @var bool whether to perform validation when the input field loses focus.
     * If not set, it will take the value of [[ActiveForm::validateOnBlur]].
     */
    public $validateOnBlur;
    /**
     * @var bool whether to perform validation while the user is typing in the input field.
     * If not set, it will take the value of [[ActiveForm::validateOnType]].
     * @see validationDelay
     */
    public $validateOnType;
    /**
     * @var int number of milliseconds that the validation should be delayed when the user types in the field
     * and [[validateOnType]] is set `true`.
     * If not set, it will take the value of [[ActiveForm::validationDelay]].
     */
    public $validationDelay;
    /**
     * @var array the jQuery selectors for selecting the container, input and error tags.
     * The array keys should be `container`, `input`, and/or `error`, and the array values
     * are the corresponding selectors. For example, `['input' => '#my-input']`.
     *
     * The container selector is used under the context of the form, while the input and the error
     * selectors are used under the context of the container.
     *
     * You normally do not need to set this property as the default selectors should work well for most cases.
     */
    public $selectors = [];
    /**
     * @var array different parts of the field (e.g. input, label). This will be used together with
     * [[template]] to generate the final field HTML code. The keys are the token names in [[template]],
     * while the values are the corresponding HTML code. Valid tokens include `{input}`, `{label}` and `{error}`.
     * Note that you normally don't need to access this property directly as
     * it is maintained by various methods of this class.
     */
    public $parts = [];
    /**
     * @var bool adds aria HTML attributes `aria-required` and `aria-invalid` for inputs
     * @since 2.0.11
     */
    public $addAriaAttributes = true;

    /**
     * @var string this property holds a custom input id if it was set using [[inputOptions]] or in one of the
     * `$options` parameters of the `input*` methods.
     */
    private $_inputId;
    /**
     * @var bool if "for" field label attribute should be skipped.
     */
    private $_skipLabelFor = false;



    /**
     * Renders the whole field.
     * This method will generate the label, error tag, input tag and hint tag (if any), and
     * assemble them into HTML according to [[template]].
     * @param string|callable $content the content within the field container.
     * If `null` (not set), the default methods will be called to generate the label, error tag and input tag,
     * and use them as the content.
     * If a callable, it will be called to generate the content. The signature of the callable should be:
     *
     * ```php
     * function ($field) {
     *     return $html;
     * }
     * ```
     *
     * @return string the rendering result.
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * Renders the opening tag of the field container.
     * @return string the rendering result.
     */
    public function begin()
    {
        if ($this->form->enableClientScript) {
            $clientOptions = $this->getClientOptions();
            if (!empty($clientOptions)) {
                $this->form->attributes[] = $clientOptions;
            }
        }

        $inputID = $this->getInputId();
        $attribute = Html::getAttributeName($this->attribute);
        $options = $this->options;

        $class = isset($options['class']) ? (array)$options['class'] : [];
        $class[] = "field-$inputID";
        if ($this->model->isAttributeRequired($attribute)) {
            $class[] = $this->form->requiredCssClass;
        }

        $options['class'] = implode(' ', $class);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_CONTAINER) {
            $this->addErrorClassIfNeeded($options);
        }
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::beginTag($tag, $options);
    }

    /**
     * Generates a label tag for [[attribute]].
     * @param null|string|false $label the label to use. If `null`, the label will be generated via [[Model::getAttributeLabel()]].
     * If `false`, the generated field will not contain the label part.
     * Note that this will NOT be [[Html::encode()|encoded]].
     * @param null|array $options the tag options in terms of name-value pairs. It will be merged with [[labelOptions]].
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using [[Html::encode()]]. If a value is `null`, the corresponding attribute will not be rendered.
     * @return $this the field object itself.
     */
    public function label($label = null, $options = [])
    {
        if ($label === false) {
            $this->parts['{label}'] = '';
            return $this;
        }

        $options = array_merge($this->labelOptions, $options);
        if ($label !== null) {
            $options['label'] = $label;
        }

        if ($this->_skipLabelFor) {
            $options['for'] = null;
        }


        $this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Renders a widget as the input of the field.
     *
     * Note that the widget must have both `model` and `attribute` properties. They will
     * be initialized with [[model]] and [[attribute]] of this field, respectively.
     *
     * If you want to use a widget that does not have `model` and `attribute` properties,
     * please use [[render()]] instead.
     *
     * While widgets extending from [[Widget]] work with active field, it is preferred to use
     * [[InputWidget]] as a base class.
     *
     * For example to use the [[MaskedInput]] widget to get some date input, you can use
     * the following code, assuming that `$form` is your [[ActiveForm]] instance:
     *
     * ```php
     * $form->field($model, 'date')->widget(\yii\widgets\MaskedInput::className(), [
     *     'mask' => '99/99/9999',
     * ]);
     * ```
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @param string $class the widget class name.
     * @param array $config name-value pairs that will be used to initialize the widget.
     * @return $this the field object itself.
     */
    public function widget($class, $config = [])
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        if (is_subclass_of($class, 'yii\widgets\InputWidget')) {
            foreach ($this->inputOptions as $key => $value) {
                if (!isset($config['options'][$key])) {
                    $config['options'][$key] = $value;
                }
            }
            $config['field'] = $this;
            if (isset($config['options'])) {
                if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
                    $this->addErrorClassIfNeeded($config['options']);
                }

                if (array_key_exists('type', $config['options']) === true && $config['options']['type'] === 'textfield') {
                    $config['options']['class'] = 'mdl-textfield mdl-js-textfield mdl-textfield--floating-label';
                    $this->options['class'] = 'mdl-textfield mdl-js-textfield mdl-textfield--floating-label';
                    $this->errorOptions = ['class' => 'mdl-textfield__error', 'tag' => 'span'];
                }
                $this->addAriaAttributes($config['options']);
                $this->adjustLabelFor($config['options']);
            }
        }

        $this->parts['{input}'] = $class::widget($config);

        return $this;
    }
}

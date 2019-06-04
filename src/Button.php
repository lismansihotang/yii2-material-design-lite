<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package Widget/button
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#buttons-section
 */

namespace lismansihotang\mdl\src;

use yii\helpers\Url;
use yii\web\JsExpression;

class Button extends \yii\base\Widget
{
    const TYPE_DEFAULT = ['mdl-button', 'mdl-js-button'];
    const TYPE_FAB = ['mdl-button', 'mdl-js-button', 'mdl-button--fab'];
    const TYPE_MINI_FAB = ['mdl-button', 'mdl-js-button', 'mdl-button--fab', 'mdl-button--mini-fab'];
    const TYPE_RAISED = ['mdl-button', 'mdl-js-button', 'mdl-button--raised'];
    const TYPE_ICON = ['mdl-button', 'mdl-js-button', 'mdl-button--icon'];

    /**
     * $var array $options
     * - 'class'
     * - 'id'
     */
    public $options = [
        'class' => null,
        'id' => null
    ];
    /**
     * $var array $content
     */
    public $content = [
        'label' => null,
        'action' => null,
        'type' => self::TYPE_DEFAULT,
        'icon' => null
    ];
    /**
     * $var type $effect
     */
    public $effect = null;
    /**
     * $var type $submit
     */
    public $submit = false;

    public $disabled = false;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->options['class'] = implode(' ', $this->setClass());
        $this->options['id'] = $this->getId();
        if (array_key_exists('action', $this->content) && $this->content['action'] !== null) {
            $this->view->registerJs(new JsExpression('$("#' . $this->options['id'] . '").on("click", function(){
                window.location.href = "' . Url::to($this->content['action']) . '";
            });'));
        }
        $this->disabledButton();
        return \yii\helpers\Html::tag(($this->submit) ? 'submit' : 'button', $this->getIcon() . $this->content['label'], $this->options);
    }

    /**
     * {@inheritdoc}
     */
    protected function disabledButton()
    {
        if ($this->disabled === true) {
            return $this->options['disabled'] = 'disabled';
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getIcon()
    {
        $icon = null;
        if (array_key_exists('icon', $this->content) === true) {
            $icon = \yii\helpers\Html::tag('i', $this->content['icon'], ['class' => 'material-icons']);
        }
        return $icon;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEffect($id)
    {
        $arrEffect = [
            'accent' => 'mdl-button--accent',
            'colored' => 'mdl-button--colored',
            'primary' => 'mdl-button--primary',
            'ripple-effect' => 'mdl-js-ripple-effect',
        ];
        $effect = 'mdl-button--accent';
        if (array_key_exists($id, $arrEffect) === true) {
            $effect = $arrEffect[$id];
        }
        return $effect;
    }

    /**
     * {@inheritdoc}
     */
    protected function setClass()
    {
        $class = $this->baseClass();
        if ($this->effect !== null) {
            array_push($class, $this->getEffect($this->effect));
        }
        return $class;
    }

    /**
     * {@inheritdoc}
     */
    protected function baseClass()
    {
        $type = self::TYPE_RAISED;
        if (array_key_exists('type', $this->content) === true) {
            $type = $this->content['type'];
        }
        return $type;
    }
}

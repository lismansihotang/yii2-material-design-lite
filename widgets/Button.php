<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package Widget/button
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#buttons-section
 */

//use lismansihotang\mdl\helpers\Html;

namespace lismansihotang\mdl\widgets;

use yii\helpers\Url;
use yii\web\JsExpression;

class Button extends \yii\base\Widget
{
    public $options = [
        'class' => null,
        'id' => null
    ];
    public $content = [
        'label' => null,
        'action' => null
    ];
    public $effect = null;
    public $submit = false;

    public function run()
    {
        $this->options['class'] = implode(' ', $this->setClass());
        $this->options['id'] = $this->getId();
        if (array_key_exists('action', $this->content) && $this->content['action'] !== null) {
            $this->view->registerJs(new JsExpression('$("#' . $this->options['id'] . '").on("click", function(){
                window.location.href = "' . Url::to($this->content['action']) . '";
            });'));
        }
        return \yii\helpers\Html::tag(($this->submit) ? 'submit' : 'button', $this->content['label'], $this->options);
    }

    protected function getEffect($id)
    {
        $arrEffect = [
            'accent' => 'mdl-button--accent',
            'colored' => 'mdl-button--colored',
            'primary' => 'mdl-button--primary',
            'rippleEffect' => 'mdl-js-ripple-effect',
        ];
        $effect = 'mdl-button--accent';
        if (array_key_exists($id, $arrEffect) === true) {
            $effect = $arrEffect[$id];
        }
        return $effect;
    }

    protected function setClass()
    {
        $class = $this->baseClass();
        if ($this->effect !== null) {
            array_push($class, $this->getEffect($this->effect));
        }
        return $class;
    }

    protected function baseClass()
    {
        return ['mdl-button', 'mdl-js-button', 'mdl-button--raised'];
    }
}

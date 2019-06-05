<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package Card
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#cards-section
 */

namespace lismansihotang\mdl\src;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

class Card extends \yii\base\Widget
{
    const TYPE_WIDE = 'card-wide';
    const TYPE_SQUARE = 'card-square';
    const TYPE_IMAGE = 'card-image';
    const TYPE_EVENT = 'card-event';

    public $options = [
        'type' => self::TYPE_WIDE
    ];

    public $shadowDepth = 2;
    public $title;
    public $content = null;
    public $image = null;
    public $button = [
        ['label' => null, 'action' => ['#'], 'icon' => 'event']
    ];
    public $menu = [
        ['icon' => null, 'action' => ['#']]
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->renderCss();
        return Html::tag('div', $this->setHeader() . $this->setContent() . $this->setButton() . $this->setMenu(), ['class' => implode(' ', $this->setBaseClass())]);
    }

    /**
     * {@inheritdoc}
     */
    protected function renderCss()
    {
        $css = 'a:hover,a:focus{text-decoration: none;}';
        if ($this->options['type'] === self::TYPE_WIDE) {
            $css .= '.' . self::TYPE_WIDE . '.mdl-card {width: 512px;}';
            $css .= '.' . self::TYPE_WIDE . ' > .mdl-card__title {color: #fff; height: 176px; background: url(' . $this->image . ') center / cover;}';
            $css .= '.' . self::TYPE_WIDE . ' > .mdl-card__menu {color: #fff;}';
        }
        if ($this->options['type'] === self::TYPE_SQUARE) {
            $css .= '.' . self::TYPE_SQUARE . '.mdl-card {width: 320px; height: 320px;}';
            $css .= '.' . self::TYPE_SQUARE . ' > .mdl-card__title {color: #fff; background: url(' . $this->image . ') bottom right 15% no-repeat #46B6AC;}';
        }
        if ($this->options['type'] === self::TYPE_IMAGE) {
            $css .= '.' . self::TYPE_IMAGE . '.mdl-card {width: 256px; height: 256px; background: url(' . $this->image . ') center / cover;}';
            $css .= '.' . self::TYPE_IMAGE . ' > .mdl-card__actions {height: 52px; padding: 16px; background: rgba(0, 0, 0, 0.2);}';
            $css .= '.card-image__filename {color: #fff; font-size: 14px; font-weight: 500;}';
        }
        if ($this->options['type'] === self::TYPE_EVENT) {
            $css .= '.' . self::TYPE_EVENT . '.mdl-card {width: 256px; height: 256px; background: #3E4EB8;}';
            $css .= '.' . self::TYPE_EVENT . ' > .mdl-card__actions {border-color: rgba(255, 255, 255, 0.2);}';
            $css .= '.' . self::TYPE_EVENT . ' > .mdl-card__title {align-items: flex-start;}';
            $css .= '.' . self::TYPE_EVENT . ' > .mdl-card__title > h4 {margin-top: 0;}';
            $css .= '.' . self::TYPE_EVENT . ' > .mdl-card__actions {display: flex; box-sizing:border-box; align-items: center;}';
            $css .= '.' . self::TYPE_EVENT . ' > .mdl-card__actions > .material-icons {padding-right: 10px;}';
            $css .= '.' . self::TYPE_EVENT . ' > .mdl-card__title, .' . self::TYPE_EVENT . ' > .mdl-card__actions, .' . self::TYPE_EVENT . ' > .mdl-card__actions > .mdl-button {color: #fff;}';
        }

        return $this->view->registerCss($css);
    }

    /**
     * {@inheritdoc}
     */
    protected function setHeader()
    {
        $class = 'mdl-card__title';
        if ($this->options['type'] !== self::TYPE_WIDE) {
            $class .= ' mdl-card--expand';
        }
        return Html::tag('div', Html::tag('h2', $this->title, ['class' => 'mdl-card__title-text']), ['class' => $class]);
    }

    /**
     * {@inheritdoc}
     */
    protected function setContent()
    {
        if ($this->content !== null) {
            return Html::tag('div', $this->content, ['class' => 'mdl-card__supporting-text']);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function setButton()
    {
        if ($this->options['type'] === self::TYPE_IMAGE) {
            return Html::tag('div', Html::tag('span', (isset($this->button['label'])) ? $this->button['label'] : null, ['class' => 'card-image__filename']), ['class' => 'mdl-card__actions']);
        }
        return Html::tag('div', implode(' ', $this->getButton()), ['class' => 'mdl-card__actions mdl-card--border']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getButton()
    {
        $result = [];
        if (is_array($this->button) === true) {
            if (array_key_exists(0, $this->button) === true) {
                for ($i = 0; $i < count($this->button); $i++) {
                    if (array_key_exists('label', $this->button[$i]) === true) {
                        $action = (array_key_exists('action', $this->button[$i]) === true) ? Url::to($this->button[$i]['action']) : Url::to(['#']);
                        $result[] = Html::a($this->button[$i]['label'], $action, ['class' => 'mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect']);
                    }
                }
            } else {
                $action = (array_key_exists('action', $this->button) === true) ? Url::to($this->button['action']) : Url::to(['#']);
                $icon = null;
                if ($this->options['type'] === self::TYPE_EVENT) {
                    $icon = Html::tag('div', null, ['class' => 'mdl-layout-spacer']) . Html::tag('i', $this->button['icon'], ['class' => 'material-icons']);
                }
                $result[] = Html::a($this->button['label'], $action, ['class' => 'mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect']) . $icon;
            }
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function setMenu()
    {
        return Html::tag('div', implode(' ', $this->getMenu()), ['class' => 'mdl-card__menu']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu()
    {
        $result = [];
        if (is_array($this->menu) === true) {
            if (array_key_exists(0, $this->menu) === true) {
                for ($i = 0; $i < count($this->menu); $i++) {
                    if (array_key_exists('icon', $this->menu[$i]) === true) {
                        $action = (array_key_exists('action', $this->menu[$i]) === true) ? Url::to($this->menu[$i]['action']) : Url::to(['#']);
                        $result[] = Html::tag('button', Html::tag('i', $this->menu[$i]['icon'], ['class' => 'material-icons']), ['class' => 'mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'id' => 'action-' . $i]);
                        $this->view->registerJs(new JsExpression('$("#action-' . $i . '").on("click", function(){
                            window.location.href = "' . $action . '";
                        });'));
                    }
                }
            } else {
                $action = (array_key_exists('action', $this->menu) === true) ? Url::to($this->menu['action']) : Url::to(['#']);
                $result[] = Html::tag('button', Html::tag('i', $this->menu['icon'], ['class' => 'material-icons']), ['class' => 'mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'id' => 'action-0']);
                $this->view->registerJs(new JsExpression('$("#action-0").on("click", function(){
                    window.location.href = "' . $action . '";
                });'));
            }
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function setBaseClass()
    {
        $result = [$this->options['type'], 'mdl-card', 'mdl-shadow--' . $this->setShadowDepth($this->shadowDepth)];
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function setShadowDepth($getShadowDepth)
    {
        $result = '2dp';
        $arrListShadowDept = [
            '2' => '2', '3' => '3', '4' => '4', '6' => '6', '8' => '8', '16' => '16'
        ];
        if (array_key_exists($getShadowDepth, $arrListShadowDept) === true) {
            $result = $arrListShadowDept[$getShadowDepth] . 'dp';
        }
        return $result;
    }
}

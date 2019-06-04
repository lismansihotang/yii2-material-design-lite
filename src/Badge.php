<?php
/**
 * @copyright Copyright &copy; lismansihotang/yii2-material-design-lite, 2019
 * @package Badge
 * @version 1.0.0
 * @author Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @resource https://getmdl.io/components/index.html#badges-section
 */

namespace lismansihotang\mdl\src;

use yii\helpers\Html;

class Badge extends \yii\base\Widget
{
    const TYPE_DEFAULT = 'mdl-badge';
    const TYPE_ICON = 'material-icons mdl-badge mdl-badge--overlap';

    public $type_icon = false;
    public $options = [];
    public $label = null;

    public function run()
    {
        $this->options['class'] = ($this->type_icon) ? self::TYPE_ICON : self::TYPE_DEFAULT;

        return Html::tag('span', $this->label, $this->options);
    }
}

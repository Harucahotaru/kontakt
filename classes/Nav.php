<?php

namespace app\classes;

use yii\base\InvalidConfigException;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class Nav extends \yii\bootstrap5\Nav
{
    public $dropdownClass = Dropdown::class;
    public $withoutLink = false;

    public function renderItem($item): string
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = $item['encode'] ?? $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $disabled = ArrayHelper::getValue($item, 'disabled', false);
        $active = $this->isItemActive($item);

        if (empty($items)) {
            $items = '';
            Html::addCssClass($options, ['widget' => 'nav-item']);
            Html::addCssClass($linkOptions, ['widget' => 'nav-link']);
        } else {
            $linkOptions['data']['bs-toggle'] = 'dropdown';
            $linkOptions['role'] = 'button';
            $linkOptions['aria']['expanded'] = 'false';
            $label .= '<i class="px-2 fa-solid fa-angle-down angle"></i>';
            Html::addCssClass($options, ['widget' => 'dropdown nav-item']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle nav-link']);
            if (is_array($items)) {
                $items = $this->isChildActive($items, $active);
                $items = $this->renderDropdown($items, $item);
            }
        }

        if ($disabled) {
            ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
            ArrayHelper::setValue($linkOptions, 'aria.disabled', 'true');
            Html::addCssClass($linkOptions, ['disable' => 'disabled']);
        } elseif ($this->activateItems && $active) {
            Html::addCssClass($linkOptions, ['activate' => 'active']);
        }
        if (empty($item['withoutLink'])) {
            $label = Html::a($label, $url, $linkOptions);
        }
        return Html::tag('li',  $label. $items, $options);
    }
}
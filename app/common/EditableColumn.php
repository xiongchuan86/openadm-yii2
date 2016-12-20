<?php
/**
 * 修改 yii2mod\editable\EditableColumn 的 renderDataCellContent 方法
 * 兼容性更强
 * @author chuan xiong <xiongchuan86@gmail.com>
 */
namespace app\common;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\editable\bundles\EditableAddressAsset;
use yii2mod\editable\bundles\EditableBootstrapAsset;
use yii2mod\editable\bundles\EditableComboDateAsset;
use yii2mod\editable\bundles\EditableDatePickerAsset;
use yii2mod\editable\bundles\EditableDateTimePickerAsset;

/**
 * Class EditableColumn
 *
 * @package yii2mod\editable
 */
class EditableColumn extends DataColumn
{
    /**
     * Editable options
     */
    public $editableOptions = [];

    /**
     * @var string suffix substituted to a name class of the tag <a>
     */
    public $classSuffix;

    /**
     * @var string the url to post
     */
    public $url;

    /**
     * @var string the type of editor
     */
    public $type = 'text';

    /**
     * @inheritdoc
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->url === null) {
            throw new InvalidConfigException('Url can not be empty.');
        }
        parent::init();

        if (!$this->format) {
            $this->format = 'raw';
        }

        $rel = $this->attribute . '_editable' . $this->classSuffix;
        $this->options['pjax'] = '0';
        $this->options['rel'] = $rel;

        $this->registerClientScript();
    }

    /**
     * Renders the data cell content.
     *
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]]
     *
     * @return string the rendering result
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = parent::renderDataCellContent($model, $key, $index);
        $url = (array)$this->url;
        $this->options['data-url'] = Url::to($url);
        $this->options['data-pk'] = $key;
        $this->options['data-name'] = $this->attribute;
        $this->options['data-type'] = $this->type;
        $opts = null;
        if (is_callable($this->editableOptions)) {
            $opts = call_user_func($this->editableOptions, $model, $key, $index);

        } elseif (is_array($this->editableOptions)) {
            $opts = $this->editableOptions;
        }
        //增加特性,当返回的数据不是数组的时候,返回常规的table cell 的数据
        if(is_array($opts)){
            foreach ($opts as $prop => $v) {
                $this->options['data-' . $prop] = $v;
            }
        }else{
            return $value;
        }


        return Html::a($value, null, $this->options);
    }

    /**
     * Registers required script to the columns work
     */
    protected function registerClientScript()
    {
        $view = $this->grid->getView();
        switch ($this->type) {
            case 'address':
                EditableAddressAsset::register($view);
                break;
            case 'combodate':
                EditableComboDateAsset::register($view);
                break;
            case 'date':
                EditableDatePickerAsset::register($view);
                break;
            case 'datetime':
                EditableDateTimePickerAsset::register($view);
                break;
            default:
                EditableBootstrapAsset::register($view);
        }

        $rel = $this->options['rel'];
        $selector = "a[rel=\"$rel\"]";
        $js[] = ";jQuery('$selector').editable();";
        $view->registerJs(implode("\n", $js));
    }
}

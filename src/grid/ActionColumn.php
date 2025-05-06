<?php

namespace phuongdev89\base\grid;

use kartik\grid\ColumnTrait;
use kartik\grid\GridView;
use Yii;
use yii\base\InvalidConfigException;

class ActionColumn extends \kartik\grid\ActionColumn
{
    use ColumnTrait;

    public $deleteOptions = ['class' => 'btn btn-sm btn-danger'];
    public $updateOptions = ['class' => 'btn btn-sm btn-warning'];
    public $viewOptions = ['class' => 'btn btn-sm btn-success'];

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->initColumnSettings([
            'hiddenFromExport' => true,
            'mergeHeader' => true,
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'width' => $this->width != '' ? $this->width : '120px',
        ]);
        $this->_isDropdown = ($this->grid->bootstrap && $this->dropdown);
        if (!isset($this->header)) {
            $this->header = Yii::t('kvgrid', 'Actions');
        }
        $this->parseFormat();
        $this->parseVisibility();
        parent::init();
        $this->initDefaultButtons();
        $this->setPageRows();
    }

}

<?php

namespace phuongdev89\base\models;

use phuongdev89\base\traits\TimestampTrait;
use yii\base\ModelEvent;
use yii\db\AfterSaveEvent;

/**
 * Class Mysql
 * @package common\components
 */
class ActiveRecord extends \yii\db\ActiveRecord
{

    use TimestampTrait;

    const STATUS = [
        self::STATUS_DISABLE => 'Disabled',
        self::STATUS_ENABLE => 'Enabled',
    ];

    const STATUS_ENABLE = 1;

    const STATUS_DISABLE = 0;

    const SCENARIO_NO_TIMESTAMP = 'no-timestamp';

    /**
     * @param null $data
     * @param int $index
     *
     * @return array
     */
    public static function statusLabels(int $index, $data = null)
    {
        if ($data == null) {
            $data = [
                'danger',
                'warning',
                'success',
            ];
        }
        return $data[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function updateAttributes($attributes)
    {
        if ($this->hasAttribute('updated_at')) {
            $attributes['updated_at'] = time();
        }
        $event = new ModelEvent();
        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
        $parent = parent::updateAttributes($attributes);
        if ($parent > 0) {
            $this->trigger(self::EVENT_AFTER_UPDATE, new AfterSaveEvent([
                'changedAttributes' => $attributes,
            ]));
            return $parent;
        }
        return 0;
    }
}

<?php

namespace phuongdev89\base\traits;

use phuongdev89\base\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

trait TimestampTrait
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if ($this->scenario != 'no-timestamp' && $this->hasAttribute('created_at') && $this->hasAttribute('updated_at')) {
            $behaviors['timestamp'] = [
                'class' => TimestampBehavior::class,
            ];
        }
        return $behaviors;
    }

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $parent = parent::scenarios();
        if ($this->hasAttribute('created_at') && $this->hasAttribute('updated_at')) {
            return ArrayHelper::merge($parent, [self::SCENARIO_NO_TIMESTAMP => array_keys($this->attributes)]);
        }
        return $parent;
    }
}

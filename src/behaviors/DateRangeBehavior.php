<?php

namespace phuongdev89\base\behaviors;

use yii\base\Event;
use yii\base\InvalidValueException;
use yii\base\Model;

/**
 * Class DateRangeBehavior
 * @package common\behaviors
 */
class DateRangeBehavior extends \kartik\daterange\DateRangeBehavior
{

    /**
     * @param Event $event
     */
    public function afterValidate($event)
    {
        if ($this->owner->hasErrors() || $event->name != Model::EVENT_AFTER_VALIDATE) {
            return;
        }
        $dateRangeValue = $this->owner->{$this->attribute};
        if (empty($dateRangeValue)) {
            return;
        }
        if ($this->singleDate) {
            $this->setOwnerAttribute($this->dateAttribute, $this->dateFormat, $dateRangeValue);
        } else {
            $separator = empty($this->separator) ? ' - ' : $this->separator;
            $dates = explode($separator, $dateRangeValue, 2);
            if (count($dates) !== 2) {
                throw new InvalidValueException("Invalid date range: '{$dateRangeValue}'.");
            }
            $dates[1] = date('Y-m-d', strtotime($dates[1]) + 86400);
            $this->setOwnerAttribute($this->dateStartAttribute, $this->dateStartFormat, $dates[0]);
            $this->setOwnerAttribute($this->dateEndAttribute, $this->dateEndFormat, $dates[1]);
        }
    }
}

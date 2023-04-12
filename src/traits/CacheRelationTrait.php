<?php

namespace phuongdev89\base\traits;

use yii\db\ActiveQuery;

/**
 * This trait will using to cache query of relation to cache components.
 */
trait CacheRelationTrait
{

    /**
     * Return array of classes that should be cached
     * Example:
     * public function cacheRelation() {
     *    return [
     *       'common\models\User' => 60, //That means relation from this model to User will be cached in 60 seconds.
     *    ];
     * }
     * @return mixed
     */
    abstract public function cacheRelation(): array;

    /**
     * Override hasOne to set cache
     *
     * @param $class
     * @param $link
     *
     * @return ActiveQuery
     */
    public function hasOne($class, $link): ActiveQuery
    {
        $hasOne = parent::hasOne($class, $link);
        if (($duration = $this->needToCache($class)) !== false) {
            $hasOne = $hasOne->cache($duration);
        }
        return $hasOne;
    }

    /**
     * Override hasMany to set cache
     *
     * @param $class
     * @param $link
     *
     * @return ActiveQuery
     */
    public function hasMany($class, $link): ActiveQuery
    {
        $hasMany = parent::hasMany($class, $link);
        if (($duration = $this->needToCache($class)) !== false) {
            $hasMany = $hasMany->cache($duration);
        }
        return $hasMany;
    }

    /**
     * Return false or time in seconds to cached
     *
     * @param $class
     *
     * @return false|int
     */
    private function needToCache($class)
    {
        $cacheRelation = $this->cacheRelation();
        if (in_array($class, array_keys($cacheRelation))) {
            return $cacheRelation[$class];
        }
        return false;
    }
}

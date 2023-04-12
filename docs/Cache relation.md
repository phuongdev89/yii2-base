# Cache relation
Using for cache the relation record.

```php

use phuongdev89\base\traits\CacheRelationTrait;
class Order extends \phuongdev89\base\models\ActiveRecord
{
    use CacheRelationTrait;
    // ...
    public function cacheRelation(): array
    {
        return [
            'common\models\User' => 60, //That means relation from this model to User will be cached in 60 seconds.
            'common\models\Product' => 600, //That means relation from this model to Product will be cached in 600 seconds.
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(Order::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}

```

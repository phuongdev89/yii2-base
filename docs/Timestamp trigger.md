# Timestamp trigger

### In model
Use my ActiveRecord (prefer)
```php
/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $created_at
 * @property int $updated_at
*/
class User extends \phuongdev89\base\models\ActiveRecord
{
    // ...
}
```
or use yii2 base ActiveRecord
```php
/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $created_at
 * @property int $updated_at
*/
use phuongdev89\base\traits\TimestampTrait;
use yii\base\ModelEvent;
use yii\db\AfterSaveEvent;

class User extends \yii\db\ActiveRecord
{
    use TimestampTrait;

    const SCENARIO_NO_TIMESTAMP = 'no-timestamp';

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
    
    // ...
}
```
### In code
```php
class TestController extends Controller
{
    /**
    * Testing without saving created_at & updated_at
    * Output is:
    *   array(
    *     'id' => 1,
    *     'username' => 'test',
    *     'password' => '123456',
    *     'created_at' => null,
    *     'updated_at' => null,
    *   ) 
    */
    public function actionA()
    {
        $model = new User(['scenario' => User::SCENARIO_NO_TIMESTAMP]);
        $model->username = 'test';
        $model->password = '123456';
        if($model->save())
        {
            print_r($model->attributes);
        }
    }
    
    /**
    * Testing without saving created_at & updated_at
    * Output is:
    *   array(
    *     'id' => 1,
    *     'username' => 'test',
    *     'password' => '123456',
    *     'created_at' => 1659066948,
    *     'updated_at' => 1659066948,
    *   ) 
    */
    public function actionA()
    {
        $model = new User();
        $model->username = 'test';
        $model->password = '123456';
        if($model->save())
        {
            print_r($model->attributes);
        }
    }
} 
```

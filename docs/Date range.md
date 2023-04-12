# DateRangeBehavior
```php
use phuongdev89\base\behaviors\DateRangeBehavior;

class UserSearch extends User
{

    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'created_at',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }

    public function rules()
    {
        return [
            // ...
            [['created_at'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        
        // ...

        $query->andFilterWhere(['>=', 'created_at', $this->createTimeStart])
              ->andFilterWhere(['<', 'created_at', $this->createTimeEnd]);

        return $dataProvider;
    }
}

```

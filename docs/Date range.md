# DateRangeBehavior
## Requirement
in `composer.json`
```composer
// ...
  "require": {
    "phuongdev89/yii2-base": "@dev",
    "kartik-v/yii2-date-range": "@dev",
    "kartik-v/yii2-gridview": "@dev",
// ...
```
### In search model
```php
use phuongdev89\base\behaviors\DateRangeBehavior;

class UserSearch extends User
{

    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            // ...
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
        // ...

        return $dataProvider;
    }
}
```

### In controller
```php
class OrderController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new OrderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    // ...
}
```

### In gridview
```php
<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = 'Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                // ...
                [
                    'class' => DataColumn::class,
                    'attribute' => 'created_at',
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => [
                        'readonly' => 'readonly',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale' => ['format' => 'Y-m-d'],
                            'autoclose' => true,
                        ],
                        'pluginEvents' => [
                            "cancel.daterangepicker" => 'function(ev,picker){$(this).val("").trigger("change");}',
                        ],
                    ],
                    'value' => function (Order $data) {
                        return date('Y-m-d H:i:s', $data->created_at);
                    },
                ],
                // ...
                
            ]
        ]);
    } catch (Exception $e) {
    }
    ?>
</div>
```

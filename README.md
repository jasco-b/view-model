# Yii2 view model

View model for Yii2 inspired from [laravel view model](https://github.com/spatie/laravel-view-models)

# Installation
You can install the package via composer:
```sh
composer require jasco-b/view-model
```

# Usage
Offen in Yii2 or any other frameworks in CRUD`s, it is required from developer use the same data in create and update actions.
For instance:
### Old Controller
```php 
class PostController extends Controller
{
  ...
  
  public function actionCreate() 
  {
      $model = new Post();
      $categories = Categories::find()->all();
      ...
      
      return $this->render('create', [
        'model'         => $model,
        'categories'    => $categories,
      ]);
  }
  
    public function actionUpdate($id) 
    {
      $model = $this->findModel($id);
      $categories = Categories::find()->all();
      ...
      
      return $this->render('update', [
        'model'         => $model,
        'categories'    => $categories,
      ]);
    }

}
```
As you have seen above, $categoreis has been used in Create and Update action. 
You can make clean controller and even you can add to view model your comlex logic.

### View model
```php

...
use jascoB\ViewModel\ViewModel;

class PostViewModel extends ViewModel
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
    
    public function categories()
    {
        return $categories = Categories::find()->all();
    }
}
```

### Controller
```php 
class PostController extends Controller
{
  ...
  
  public function actionCreate() 
  {
      $model = new Post();
      ...
      
      return $this->render('create', new PostViewModel($model));
  }
  
    public function actionUpdate($id) 
    {
      $model = $this->findModel($id);
      ...
      
      return $this->render('update', new PostViewModel($model));
    }

}
```

In order use view model vith Yii2 we should change config.php
```php 
return [
    'components' => [
        'view'=>[
            'class'=>'jascoB\ViewModel\Classes\View',
        ],
    ],
];
```


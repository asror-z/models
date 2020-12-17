<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\shop;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\shop\ShopOptionTypeForm;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\navigat\ZDownloadWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\shop\ShopBrand;
use zetsoft\models\shop\ShopReviewOption;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopProduct;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\user\User;



/**
 * Class    ShopCategory
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $icon
 * @property array $shop_brand_ids
 * @property array $shop_review_option_ids
 * @property array $shop_option_type
 * @property int $shop_category_id
 * @property array $image
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopCategory extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $icon;
    public $shop_brand_ids;
    public $shop_review_option_ids;
    public $shop_option_type;
    public $shop_category_id;
    public $image;
    public $deleted_at;
    public $deleted_by;
    public $deleted_text;
    public $created_at;
    public $modified_at;
    public $created_by;
    public $modified_by;
    */

    #endregion

    #region Attrs

    public const attrs = [

        'id',
        'sort',
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'icon',
        'shop_brand_ids',
        'shop_review_option_ids',
        'shop_option_type',
        'shop_category_id',
        'image',
        'deleted_at',
        'deleted_by',
        'deleted_text',
        'created_at',
        'modified_at',
        'created_by',
        'modified_by',
    ];

    #endregion

    #region Names

    #endregion

    #region Const

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Категории';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();


    }

    #endregion

    #region Fields
    
   public function fields()
   {
       return [
			'id',
			'sort',
			'name',
			'title',
			'tranz',
			'accept',
			'active',
			'icon',
			'shop_brand_ids',
			'shop_review_option_ids',
			'shop_option_type',
			'shop_category_id',
			'image',
			'deleted_at',
			'deleted_by',
			'deleted_text',
			'created_at',
			'modified_at',
			'created_by',
			'modified_by',

       ];
   }

    #endregion

    #region Config
    
    /**
     * Function  config
     * @return  \Closure
     */

    public function config()
    {
        return function (ConfigDB $config) {

                                                                                                                                    $config->query = function ($model) {
                if ($this->hasRole('seller'))
                    return static::find()
                        ->where([
                            'created_by' => $this->userIdentity()->id
                        ]);

                return null;

            };

            $config->nameLang = true;
            $config->hasOne = [
                    'ShopCategory' => [
                        'shop_category_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'ShopBrand' => [
                        'shop_brand_ids' => 'id',
                    ],
                    'ShopReviewOption' => [
                        'shop_review_option_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopCategory' => [
                        'shop_category_id' => 'id',
                    ],
                    'ShopCoupon' => [
                        'shop_category_id' => 'id',
                    ],
                    'ShopProduct' => [
                        'shop_category_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Категории');

            return $config;
        };
    }


    #endregion

    #region Column

    /**
     * Function column
     * @return array
     */
    public function column()
    {
        if (!empty($this->configs->column))
            return $this->configs->column;

        return ZArrayHelper::merge(parent::column(), [

            'icon' => function (FormDb $column) {

                $column->title = Az::l('Иконка');
                $column->tooltip = Az::l('Иконка для Магазина');
                //$column->widget = ZIconPickerWidget::class;

                return $column;
            },
            


            'shop_brand_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Бренды');
                $column->tooltip = Az::l('Доступные бренды магазина');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'shop_review_option_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Опции для отзывов');
                $column->tooltip = Az::l('Опции для отзывов магазина');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'shop_option_type' => function (FormDb $column) {

                $column->title = Az::l('Параметры опций');
                $column->tooltip = Az::l('Доступные параметры опций магазинов');
                $column->dbType = dbTypeJsonb;

                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;
                $column->changeReload = true;
                $column->changeSave = true;

                $column->options = [
                    'config' => [
                        'model' => $this,
                        'attribute' => 'home',
                        'formClass' => ShopOptionTypeForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'model' => $this,
                        'attribute' => 'home',
                        'formClass' => ShopOptionTypeForm::class,
                    ],
                ];

                return $column;
            },


            'shop_category_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящий');
                $column->tooltip = Az::l('Связанный вышестоящая категория');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'image' => function (FormDb $column) {

                $column->title = Az::l('Картина');
                $column->tooltip = Az::l('Картина магазина');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->valueWidget = ZDownloadWidget::class;
                $column->options = [
                    'config' => [
                        'maxFileCount' => '5',
                    ],
                ];

                $column->mergeHeader = true;

                return $column;
            },


        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'sort',
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'icon',
        'shop_brand_ids',
        'shop_review_option_ids',
        'shop_option_type',
        'shop_category_id',
        'image',
        'deleted_at',
        'deleted_by',
        'deleted_text',
        'created_at',
        'modified_at',
        'created_by',
        'modified_by',

    */

    #endregion


    #region Cards

    /**
     * Function  blocks
     * @return  array
     */

    public function card()
    {
        return [
            [
                'title' => Az::l('Первый этап'),
                'shows' => true,
                'items' => [
                    [
                        'title' => Az::l('Форма'),
                        'shows' => true,
                        'items' => [
                            [
                                'id',
                                'sort',
                                'name',
                                'title',
                                'tranz',
                                'active',
                                'icon',
                                'shop_brand_ids',
                                'shop_review_option_ids',
                                'shop_option_type',
                                'shop_category_id',
                                'image',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopCategory $model = null)
    {

        if ($model === null)
            $model = $this;

        return null;
    }


    ##endregion

    #region Events

    /**
     * Function column
     * @return ZEvent
     */
    public function event()
    {
        $event = new Event();

        /*   $event->afterSave = function (ShopCategory $model) {
               if (!$this->isCLI())
                   if (!ZArrayHelper::getValue(Az::$app->params, 'sortCategory'))
                       if (!$this->isNewRecord) {


                           //Az::$app->market->product->afterEditCorecategory($model->id);
                           //$url = $this->urlGetBase() . "/admin/core-category/queue.aspx?namespace=cores&service=product&method=afterEditCorecategory&args=$model->id";
                           // $url = '/shop/admin/core-category/queue.aspx?namespace=reacts&service=childprocess&method=runcommand&args=ping mail.ru -t';

                          $url = $this->urlGetBase() . '/core/product/afterEditCoreCategory.aspx?category_id=' . $model->id;
                           //vdd($url);
                           Az::$app->https->amphp->getRequest($url);
                       }
           };*/


        /*
        *
        * $event->afterSave = function (CoreCategory $model) {
        return null;
        };
        $event->beforeDelete = function (CoreCategory $model) {
        return null;
        };

        $event->afterDelete = function (CoreCategory $model) {
        return null;
        };

        $event->beforeSave = function (CoreCategory $model) {
        return null;
        };

        $event->afterSave = function (CoreCategory $model) {
        return null;
        };

        $event->beforeValidate = function (CoreCategory $model) {
        return null;
        };

        $event->afterValidate = function (CoreCategory $model) {
        return null;
        };

        $event->afterRefresh = function (CoreCategory $model) {
        return null;
        };

        $event->afterFind = function (CoreCategory $model) {
        return null;
        };
        */
        return $event;

    }


    #endregion


    #region Faker

    /**
     * Function column
     * @return bool
     */


    #endregion

    #region One


    /**
     *
     * Function  getShopCategory
     * @return bool|\yii\db\ActiveRecord|ShopCategory|null
     */            
    public function getShopCategoryOne()
    {
        return $this->getOne(ShopCategory::class, [
          'id' => 'shop_category_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCategory
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCategory()
    {
        return $this->hasOne(ShopCategory::class, [
          'id' => 'shop_category_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getDeletedBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getDeletedByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'deleted_by',
      ]);    
    }
    
     /**
     *
     * Function  getDeletedBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'deleted_by',
      ]);    
    }
    
    

    /**
     *
     * Function  getCreatedBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getCreatedByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'created_by',
      ]);    
    }
    
     /**
     *
     * Function  getCreatedBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'created_by',
      ]);    
    }
    
    

    /**
     *
     * Function  getModifiedBy
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getModifiedByOne()
    {
        return $this->getOne(User::class, [
          'id' => 'modified_by',
      ]);    
    }
    
     /**
     *
     * Function  getModifiedBy
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getModifiedBy()
    {
        return $this->hasOne(User::class, [
          'id' => 'modified_by',
      ]);    
    }
    
    


    #endregion

    #region Multi


    /**
     *
     * Function  getShopBrandsFromShopBrandIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopBrand
     */            
    public function getShopBrandsFromShopBrandIdsMulti()
    {
        return $this->getMulti(ShopBrand::class, [
          'id' => 'shop_brand_ids',
      ]);    
    }

    /**
     *
     * Function  getShopReviewOptionsFromShopReviewOptionIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopReviewOption
     */            
    public function getShopReviewOptionsFromShopReviewOptionIdsMulti()
    {
        return $this->getMulti(ShopReviewOption::class, [
          'id' => 'shop_review_option_ids',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getShopCategoriesWithShopCategoryIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCategory
     */            
    public function getShopCategoriesWithShopCategoryIdMany()
    {
       return $this->getMany(ShopCategory::class, [
            'shop_category_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCategoriesWithShopCategoryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCategoriesWithShopCategoryId()
    {
       return $this->hasMany(ShopCategory::class, [
            'shop_category_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopCouponsWithShopCategoryIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCoupon
     */            
    public function getShopCouponsWithShopCategoryIdMany()
    {
       return $this->getMany(ShopCoupon::class, [
            'shop_category_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCouponsWithShopCategoryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCouponsWithShopCategoryId()
    {
       return $this->hasMany(ShopCoupon::class, [
            'shop_category_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopProductsWithShopCategoryIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopProduct
     */            
    public function getShopProductsWithShopCategoryIdMany()
    {
       return $this->getMany(ShopProduct::class, [
            'shop_category_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopProductsWithShopCategoryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopProductsWithShopCategoryId()
    {
       return $this->hasMany(ShopProduct::class, [
            'shop_category_id' => 'id',
        ]);     
    }


    #endregion


}

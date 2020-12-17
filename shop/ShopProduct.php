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
use zetsoft\former\shop\ShopOptionForm;
use zetsoft\former\shop\ShopSizeForm;
use zetsoft\models\user\UserCompany;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZTextAreaWidget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopBrand;
use zetsoft\models\shop\ShopOption;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopOverview;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopReview;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\incores\ZMCheckboxWidget;
use zetsoft\models\user\User;



/**
 * Class    ShopProduct
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_company_id
 * @property int $shop_category_id
 * @property string $package
 * @property array $shop_option
 * @property string $text
 * @property array $image
 * @property array $shop_option_ids
 * @property int $shop_brand_id
 * @property array $related
 * @property int $shelf_life
 * @property string $shelf_life_unit
 * @property double $weight
 * @property array $size
 * @property array $offer
 * @property float $rating
 * @property string $measure
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopProduct extends ZActiveRecord
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
    public $user_company_id;
    public $shop_category_id;
    public $package;
    public $shop_option;
    public $text;
    public $image;
    public $shop_option_ids;
    public $shop_brand_id;
    public $related;
    public $shelf_life;
    public $shelf_life_unit;
    public $weight;
    public $size;
    public $offer;
    public $rating;
    public $measure;
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
        'user_company_id',
        'shop_category_id',
        'package',
        'shop_option',
        'text',
        'image',
        'shop_option_ids',
        'shop_brand_id',
        'related',
        'shelf_life',
        'shelf_life_unit',
        'weight',
        'size',
        'offer',
        'rating',
        'measure',
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

    /* @var array $_shelf_life_unit*/
    public $_shelf_life_unit;  
    public const shelf_life_unit = [
        'days' => 'days',
        'month' => 'month',
        'year' => 'year',
    ];

    /* @var array $_offer*/
    public $_offer;  
    public const offer = [
        'new' => 'new',
        'deal_of_day' => 'deal_of_day',
        'popular' => 'popular',
        'top_sell' => 'top_sell',
        'discount' => 'discount',
        'super_offer' => 'super_offer',
        'free_delivery' => 'free_delivery',
    ];

    /* @var array $_measure*/
    public $_measure;  
    public const measure = [
        'pcs' => 'pcs',
        'm' => 'm',
        'l' => 'l',
        'kg' => 'kg',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Продукты';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_shelf_life_unit = [
            'days' => Az::l('День'),
            'month' => Az::l('Месяц'),
            'year' => Az::l('Год'),
        ];
        
        $this->_offer = [
            'new' => Az::l('Новинка'),
            'deal_of_day' => Az::l('Товар дня'),
            'popular' => Az::l('Популярные'),
            'top_sell' => Az::l('Топ продаж'),
            'discount' => Az::l('Скидка'),
            'super_offer' => Az::l('Супер предложение'),
            'free_delivery' => Az::l('Бесплатная доставка'),
        ];
        
        $this->_measure = [
            'pcs' => Az::l('Шт'),
            'm' => Az::l('М'),
            'l' => Az::l('Л'),
            'kg' => Az::l('Кг'),
        ];
        

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
			'user_company_id',
			'shop_category_id',
			'package',
			'shop_option',
			'text',
			'image',
			'shop_option_ids',
			'shop_brand_id',
			'related',
			'shelf_life',
			'shelf_life_unit',
			'weight',
			'size',
			'offer',
			'rating',
			'measure',
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

            $config->faker = true;
            $config->indexSearch = true;
                                                                                                                                                                                    $config->query = function ($model) {

                if ($this->hasRole('seller'))
                    return static::find()
                        ->where([
                            'created_by' => $this->userIdentity()->id
                        ]);

                return null;

            };

            $config->hasOne = [
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopCategory' => [
                        'shop_category_id' => 'id',
                    ],
                    'ShopBrand' => [
                        'shop_brand_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'ShopOption' => [
                        'shop_option_ids' => 'id',
                    ],
                    1 => [
                        'related' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopCoupon' => [
                        'min_price_order' => 'id',
                        'shop_product_id' => 'id',
                    ],
                    'ShopElement' => [
                        'shop_product_id' => 'id',
                    ],
                    'ShopOverview' => [
                        'shop_product_id' => 'id',
                    ],
                    'ShopQuestion' => [
                        'shop_product_id' => 'id',
                    ],
                    'ShopReview' => [
                        'shop_product_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Продукты');
            $config->info = [
                    'СПРАВОЧНИК НОМЕНКЛАТУРА',
                ];

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


            'user_company_id' => function (FormDb $column) {

                $column->title = Az::l('Компания');
                $column->tooltip = Az::l('Компания');
                $column->widget = ZKSelect2Widget::class;
                return $column;
            },


            'shop_category_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Категория');
                $column->tooltip = Az::l('Категория продукта');
                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    
                ];
                $column->changeReload = true;
                $column->changeSave = true;

                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];

                return $column;
            },
            'package' => function (FormDb $column) {

                $column->title = Az::l('Упаковка');
                $column->tooltip = Az::l('Упаковка продукта');

                return $column;
            },


            'shop_option' => function (FormDb $column) {

                $column->title = Az::l('Параметры опций');
                $column->tooltip = Az::l('Доступные параметры опций магазинов');
                $column->dbType = dbTypeJsonb;

                $column->widget = ZMultiWidget::class;
                $column->valueWidget = ZMultiViewWidget::class;

                $column->options = [
                    'config' => [
                        'model' => $this,
                        'attribute' => 'home',
                        'formClass' => ShopOptionForm::class,
                    ],
                ];

                $column->valueOptions = [
                    'config' => [
                        'model' => $this,
                        'attribute' => 'home',
                        'formClass' => ShopOptionForm::class,
                    ],
                ];

                return $column;
            },


            'text' => function (FormDb $column) {

                $column->title = Az::l('Полное описание продукта');
                $column->tooltip = Az::l('Полное описание продукта');
                $column->dbType = dbTypeText;
                $column->widget = ZCKEditorWidget::class;
                $column->showDyna = false;
                $column->indexSearch = true;
                $column->lang = true;

                return $column;
            },


            'image' => function (FormDb $column) {

                $column->title = Az::l('Изображения');
                $column->tooltip = Az::l('Изображения продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFileInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'shop_option_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Опции продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->depends = 'shop_category_id';
                $column->namespace = 'market';
                $column->service = 'product';
                $column->method = 'getOptionsByCategory';
                $column->multiple = true;

                return $column;
            },


            'shop_brand_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Бренд');
                $column->tooltip = Az::l('Бренд продукта');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->depends = 'shop_category_id';
                $column->namespace = 'market';
                $column->service = 'Category';
                $column->method = 'getBrands';

                return $column;
            },


            'related' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Связанные товары');
                $column->tooltip = Az::l('Связанные товары к данному продукту');
                $column->dbType = dbTypeJson;
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;
                $column->fkTable = 'shop_product';
                $column->fkMulti = true;
                $column->width = '400px';

                return $column;
            },


            'shelf_life' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Срок годности');
                $column->tooltip = Az::l('Срок годности продукта в днях');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'shelf_life_unit' => function (FormDb $column) {

                $column->title = Az::l('Единица измерения срока');
                $column->tooltip = Az::l('Единица измерения срока годности продукта');
                $column->data = [
                    'days' => Az::l('День'),
                    'month' => Az::l('Месяц'),
                    'year' => Az::l('Год'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'weight' => function (FormDb $column) {

                $column->title = Az::l('Вес в кг');
                $column->tooltip = Az::l('Вес продукта в килограммах');
                $column->dbType = dbTypeDouble;

                return $column;
            },


            'size' => function (FormDb $column) {

                $column->title = Az::l('Размеры');
                $column->tooltip = Az::l('Размер продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formClass' => ShopSizeForm::class,
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formClass' => ShopSizeForm::class,
                    ],
                ];

                return $column;
            },


            'offer' => function (FormDb $column) {

                $column->title = Az::l('Специальные предложения');
                $column->tooltip = Az::l('Специальные предложения продукта');
                $column->dbType = dbTypeJsonb;
                $column->data = [
                    'new' => Az::l('Новинка'),
                    'deal_of_day' => Az::l('Товар дня'),
                    'popular' => Az::l('Популярные'),
                    'top_sell' => Az::l('Топ продаж'),
                    'discount' => Az::l('Скидка'),
                    'super_offer' => Az::l('Супер предложение'),
                    'free_delivery' => Az::l('Бесплатная доставка'),
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'rating' => function (FormDb $column) {

                $column->title = Az::l('Рейтинг');
                $column->tooltip = Az::l('Общий рейтинг продукта');
                $column->dbType = dbTypeFloat;
                $column->widget = ZKStarRatingWidget::class;

                return $column;
            },


            'measure' => function (FormDb $column) {

                $column->title = Az::l('Единица измерения');
                $column->tooltip = Az::l('Единица измерения продукта');
                $column->data = [
                    'pcs' => Az::l('Шт'),
                    'm' => Az::l('М'),
                    'l' => Az::l('Л'),
                    'kg' => Az::l('Кг'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

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
        'user_company_id',
        'shop_category_id',
        'package',
        'shop_option',
        'text',
        'image',
        'shop_option_ids',
        'shop_brand_id',
        'related',
        'shelf_life',
        'shelf_life_unit',
        'weight',
        'size',
        'offer',
        'rating',
        'measure',
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
                                'name',
                                'title',
                                'text',
                                'image',
                                'shop_category_id',
                                'shop_option_ids',
                                'shop_brand_id',
                                'related',
                                'best_before',
                                'shelf_life_unit',
                                'weight',
                                'size',
                                'offer',
                                'rating',
                                'measure',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopProduct $model = null)
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

        $event->beforeSave = function (ShopProduct $model) {
        };

        $event->afterSave = function (ShopProduct $model) {

            if ($this->paramGet($this->paramIsUpdate))
                ShopElement::deleteAll([
                    'shop_product_id' => $model->id
                ]);

            Az::$app->maths->combine->combinateProductElement($model->id);

        };

        $event->afterDelete = function (ShopProduct $model) {
            ShopElement::deleteAll([
                'shop_product_id' => $model->id,
            ]);

        };

        /*
         * 
        $event->beforeDelete = function (CoreProduct $model) {
        return null;
        };



        $event->beforeSave = function (CoreProduct $model) {
        return null;
        };

      
        $event->beforeValidate = function (CoreProduct $model) {
        return null;
        };

        $event->afterValidate = function (CoreProduct $model) {
        return null;
        };

        $event->afterRefresh = function (CoreProduct $model) {
        return null;
        };

        $event->afterFind = function (CoreProduct $model) {
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
     * Function  getUserCompany
     * @return bool|\yii\db\ActiveRecord|UserCompany|null
     */            
    public function getUserCompanyOne()
    {
        return $this->getOne(UserCompany::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
     /**
     *
     * Function  getUserCompany
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUserCompany()
    {
        return $this->hasOne(UserCompany::class, [
          'id' => 'user_company_id',
      ]);    
    }
    
    

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
     * Function  getShopBrand
     * @return bool|\yii\db\ActiveRecord|ShopBrand|null
     */            
    public function getShopBrandOne()
    {
        return $this->getOne(ShopBrand::class, [
          'id' => 'shop_brand_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopBrand
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopBrand()
    {
        return $this->hasOne(ShopBrand::class, [
          'id' => 'shop_brand_id',
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
     * Function  getShopOptionsFromShopOptionIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopOption
     */            
    public function getShopOptionsFromShopOptionIdsMulti()
    {
        return $this->getMulti(ShopOption::class, [
          'id' => 'shop_option_ids',
      ]);    
    }

    /**
     *
     * Function  getShopProductsFromRelatedMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopProduct
     */            
    public function getShopProductsFromRelatedMulti()
    {
        return $this->getMulti(ShopProduct::class, [
          'id' => 'related',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getShopCouponsWithMinPriceOrderMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCoupon
     */            
    public function getShopCouponsWithMinPriceOrderMany()
    {
       return $this->getMany(ShopCoupon::class, [
            'min_price_order' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCouponsWithMinPriceOrder
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCouponsWithMinPriceOrder()
    {
       return $this->hasMany(ShopCoupon::class, [
            'min_price_order' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopCouponsWithShopProductIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCoupon
     */            
    public function getShopCouponsWithShopProductIdMany()
    {
       return $this->getMany(ShopCoupon::class, [
            'shop_product_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCouponsWithShopProductId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCouponsWithShopProductId()
    {
       return $this->hasMany(ShopCoupon::class, [
            'shop_product_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopElementsWithShopProductIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopElement
     */            
    public function getShopElementsWithShopProductIdMany()
    {
       return $this->getMany(ShopElement::class, [
            'shop_product_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopElementsWithShopProductId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopElementsWithShopProductId()
    {
       return $this->hasMany(ShopElement::class, [
            'shop_product_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopOverviewsWithShopProductIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOverview
     */            
    public function getShopOverviewsWithShopProductIdMany()
    {
       return $this->getMany(ShopOverview::class, [
            'shop_product_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOverviewsWithShopProductId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOverviewsWithShopProductId()
    {
       return $this->hasMany(ShopOverview::class, [
            'shop_product_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopQuestionsWithShopProductIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopQuestion
     */            
    public function getShopQuestionsWithShopProductIdMany()
    {
       return $this->getMany(ShopQuestion::class, [
            'shop_product_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopQuestionsWithShopProductId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopQuestionsWithShopProductId()
    {
       return $this->hasMany(ShopQuestion::class, [
            'shop_product_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopReviewsWithShopProductIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopReview
     */            
    public function getShopReviewsWithShopProductIdMany()
    {
       return $this->getMany(ShopReview::class, [
            'shop_product_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopReviewsWithShopProductId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopReviewsWithShopProductId()
    {
       return $this->hasMany(ShopReview::class, [
            'shop_product_id' => 'id',
        ]);     
    }


    #endregion


}

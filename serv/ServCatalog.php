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
use zetsoft\former\lang\LanguageForm;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZCKEditorWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZTextAreaWidget;
use zetsoft\widgets\values\ZFormViewWidget;
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
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\user\UserCompany;



/**
 * Class    ShopProduct
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $package
 * @property string $text
 * @property array $image
 * @property string $shop_category_id
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
 * @property boolean $autocreate
 */
class ShopProduct extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $name;
    public $title;
    public $package;
    public $text;
    public $image;
    public $shop_category_id;
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
    public $autocreate;
    */

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
			'name',
			'title',
			'package',
			'text',
			'image',
			'shop_category_id',
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
			'autocreate',

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
        return static function (ConfigDB $config) {

            $config->addBy = false;
            $config->addName = false;
            $config->faker = true;
            $config->indexSearch = true;
            $config->nameAuto = false;
            $config->hasOne = [
                    'ShopCategory' => [
                        'shop_category_id' => 'id',
                    ],
                    'ShopBrand' => [
                        'shop_brand_id' => 'id',
                    ],
                    'ShopProduct' => [
                        'related' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'ShopOption' => [
                        'shop_option_ids' => 'id',
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
                    'ShopProduct' => [
                        'related' => 'id',
                    ],
                    'ShopQuestion' => [
                        'shop_product_id' => 'id',
                    ],
                    'ShopReview' => [
                        'shop_product_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Продукты');
            $config->icon = 'fal fa-product-hunt';

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

            'name' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Название');
                $column->tooltip = Az::l('Название товара');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorString,
                    ],
                ];
                $column->indexSearch = true;
                $column->lang = true;

                return $column;
            },


            'package' => function (FormDb $column) {

                $column->title = Az::l('Упаковка');
                $column->tooltip = Az::l('Упаковка продукта');

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
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];

                return $column;
            },


            'shop_option_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Опции продукта');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true,
                        'depend' => 'shop_category_id',
                        'service' => 'product',
                        'namespace' => 'market',
                        'method' => 'getOptionsByCategory',
                    ],
                ];

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
                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'shop_category_id',
                        'service' => 'Category',
                        'namespace' => 'market',
                        'method' => 'getBrands',
                    ],
                ];

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

                $column->title = Az::l('Размер');
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

            'autocreate' => function (FormDb $column) {

                $column->title = Az::l('Создать виды товаров?');
                $column->tooltip = Az::l('Создать другие виды товаров?');
                $column->dbType = dbTypeBoolean;
                $column->widget = ZKSwitchInputWidget::class;

                return $column;
            },

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'name',
        'title',
        'package',
        'text',
        'image',
        'shop_category_id',
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
        'autocreate',

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


            // vdd($this->paramGet('paramIsUpdate'));
//            Az::debug('Starting action afterSave');
//            Az::debug('isNewRecord: ' . $this->jscode($model->isNewRecord));
            /* if (!ZArrayHelper::getValue(Az::$app->params, 'paramIsUpdate')) {
                // vdd(11);
                 Az::$app->market->element->saveElements($model);
             }*/

            if ($model->isNewRecord && $model->autocreate)
                Az::$app->market->element->saveElements($model);
        };
        $event->afterDelete = function (ShopProduct $model) {
            $elements = ShopElement::find()
                ->where([
                    'shop_product_id' => $model->id,
                ])
                ->all();

            foreach ($elements as $element)
                $element->delete();

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
    public function faker()
    {
        return null;
    }


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
     * Function  getRelated
     * @return bool|\yii\db\ActiveRecord|ShopProduct|null
     */            
    public function getRelatedOne()
    {
        return $this->getOne(ShopProduct::class, [
          'id' => 'related',
      ]);    
    }
    
     /**
     *
     * Function  getRelated
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getRelated()
    {
        return $this->hasOne(ShopProduct::class, [
          'id' => 'related',
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
     * Function  getShopProductsWithRelatedMany
     * @return  null|\yii\db\ActiveRecord[]|ShopProduct
     */            
    public function getShopProductsWithRelatedMany()
    {
       return $this->getMany(ShopProduct::class, [
            'related' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopProductsWithRelated
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopProductsWithRelated()
    {
       return $this->hasMany(ShopProduct::class, [
            'related' => 'id',
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

<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\ware;


use zetsoft\dbdata\shop\CurrencyData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputBtnWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSelect2WidgetRav;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\WareEnter;
use zetsoft\models\ware\WareSeries;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareEnterItem
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $ware_enter_id
 * @property int $shop_element_id
 * @property string $best_before
 * @property int $amount
 * @property int $price_buy
 * @property int $price
 * @property int $price_all
 * @property int $ware_series_id
 * @property string $currency
 * @property double $weight
 * @property string $measure
 * @property int $shop_catalog_id
 * @property int $shop_catalog_ware_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareEnterItem extends ZActiveRecord
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
    public $ware_enter_id;
    public $shop_element_id;
    public $best_before;
    public $amount;
    public $price_buy;
    public $price;
    public $price_all;
    public $ware_series_id;
    public $currency;
    public $weight;
    public $measure;
    public $shop_catalog_id;
    public $shop_catalog_ware_id;
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
        'ware_enter_id',
        'shop_element_id',
        'best_before',
        'amount',
        'price_buy',
        'price',
        'price_all',
        'ware_series_id',
        'currency',
        'weight',
        'measure',
        'shop_catalog_id',
        'shop_catalog_ware_id',
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
    public static ?string $title = Azl . 'Товары для поступления в склад';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

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
			'ware_enter_id',
			'shop_element_id',
			'best_before',
			'amount',
			'price_buy',
			'price',
			'price_all',
			'ware_series_id',
			'currency',
			'weight',
			'measure',
			'shop_catalog_id',
			'shop_catalog_ware_id',
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

            $config->titleId = 'Номер';

            $config->nameValue = 'Приход {id} от {created_at}';

            $config->hasOne = [
                    'WareEnter' => [
                        'ware_enter_id' => 'id',
                    ],
                    'ShopElement' => [
                        'shop_element_id' => 'id',
                    ],
                    'WareSeries' => [
                        'ware_series_id' => 'id',
                    ],
                    'ShopCatalog' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'ShopCatalogWare' => [
                        'shop_catalog_ware_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Товары для поступления в склад');
            $config->relatedSave = 1;


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


            'ware_enter_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Акт поступления');
                $column->tooltip = Az::l('Акт поступления товаров в склад');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'shop_element_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Элемент товаров');
                $column->tooltip = Az::l('Элемент товаров внутри поступления');
                /*$column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];*/
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_element';
                $column->addPlus = false;


                return $column;
            },


            'best_before' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Срок годности');
                $column->tooltip = Az::l('Срок годности товара');
                $column->dbType = dbTypeDate;
                /*$column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];*/
                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },


            'amount' => function (FormDb $column) {

                $column->title = Az::l('Количество');
                $column->tooltip = Az::l('Количество поступленных товаров в склад');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;
                $column->filterWidget = ZHInputWidget::class;
                $column->history = true;
                $column->width = '100px';

                return $column;
            },


            'price_buy' => function (FormDb $column) {

                $column->title = Az::l('Цена покупки');
                $column->tooltip = Az::l('Цена покупки товара');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;
                $column->filterWidget = ZHInputWidget::class;
                $column->width = '100px';

                return $column;
            },


            'price' => function (FormDb $column) {

                $column->title = Az::l('Цена продажи');
                $column->tooltip = Az::l('Цена продажи товара');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;
                $column->filterWidget = ZHInputWidget::class;
                $column->width = '100px';

                return $column;
            },

            'price_all' => function (FormDb $column) {

                $column->title = Az::l('Общая сумма');
                $column->tooltip = Az::l('Общая сумма товара по цене продажи');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },


            'ware_series_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Серия');
                $column->tooltip = Az::l('Серия товара');
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'tags' => true,
                    ],
                ];

                return $column;
            },


            'currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта');
                $column->tooltip = Az::l('Валюта которой считается цена');
                $column->value = 'UZS';
                $column->data = CurrencyData::class;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'weight' => function (FormDb $column) {

                $column->title = Az::l('Вес');
                $column->tooltip = Az::l('Вес товаров поступающих в склад');
                $column->dbType = dbTypeDouble;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZInputBtnWidget::class;
                $column->filterWidget = ZInputWidget::class;

                return $column;
            },


            'measure' => function (FormDb $column) {

                $column->title = Az::l('Единица измерения');
                $column->tooltip = Az::l('Единица измерения товара');
                $column->data = [
                    'pcs' => Az::l('Шт'),
                    'm' => Az::l('М'),
                    'l' => Az::l('Л'),
                    'kg' => Az::l('Кг'),
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->readonly = true;

                return $column;
            },


            'shop_catalog_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог товаров');
                $column->tooltip = Az::l('Каталог товаров  для поступления в склад');
                $column->widget = ZKSelect2Widget::class;
                return $column;
            },


            'shop_catalog_ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог товаров распределенный по складам');
                $column->tooltip = Az::l('Каталог товаров распределенный по складам для поступления в склад');
                $column->widget = ZKSelect2Widget::class;
                $column->readonly = true;

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
        'ware_enter_id',
        'shop_element_id',
        'best_before',
        'amount',
        'price_buy',
        'price',
        'price_all',
        'ware_series_id',
        'currency',
        'weight',
        'measure',
        'shop_catalog_id',
        'shop_catalog_ware_id',
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
                                'name',
                            ],
                            [
                                'title',
                                'ware_enter_id',
                            ],
                            [
                                'shop_catalog_id',
                                'shop_element_id',
                                'best_before',
                            ],
                            [
                                'amount',
                                'amount_history',
                            ],
                            [
                                'price_buy',
                                'price',
                                'price_all',
                            ],
                            [
                                'ware_series_id',
                                'currency',
                            ],
                            [
                                'weight',
                                'measure',
                            ],
                            [
                                'shop_catalog_id',
                                'shop_catalog_ware_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareEnterItem $model = null)
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

        $event->beforeSave = function (WareEnterItem $model) {
            if ($this->isNewRecord) {
                Az::$app->market->wares->enter($model);
            } else {
                Az::$app->market->wares->editWareEnter($model);
            }
        };

        /*$event->afterDelete = static function (WareEnterItem $model) {
            Az::$app->market->wares->exit($model);
        };*/
        /*
        $event->beforeDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->afterDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->beforeSave = function (ShopCatalog $model) {
        return null;
        };

        $event->afterSave = function (ShopCatalog $model) {
        return null;
        };

        $event->beforeValidate = function (ShopCatalog $model) {
        return null;
        };

        $event->afterValidate = function (ShopCatalog $model) {
        return null;
        };

        $event->afterRefresh = function (ShopCatalog $model) {
        return null;
        };

        $event->afterFind = function (ShopCatalog $model) {
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
     * Function  getWareEnter
     * @return bool|\yii\db\ActiveRecord|WareEnter|null
     */            
    public function getWareEnterOne()
    {
        return $this->getOne(WareEnter::class, [
          'id' => 'ware_enter_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareEnter
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareEnter()
    {
        return $this->hasOne(WareEnter::class, [
          'id' => 'ware_enter_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopElement
     * @return bool|\yii\db\ActiveRecord|ShopElement|null
     */            
    public function getShopElementOne()
    {
        return $this->getOne(ShopElement::class, [
          'id' => 'shop_element_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopElement
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopElement()
    {
        return $this->hasOne(ShopElement::class, [
          'id' => 'shop_element_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getWareSeries
     * @return bool|\yii\db\ActiveRecord|WareSeries|null
     */            
    public function getWareSeriesOne()
    {
        return $this->getOne(WareSeries::class, [
          'id' => 'ware_series_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareSeries
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareSeries()
    {
        return $this->hasOne(WareSeries::class, [
          'id' => 'ware_series_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopCatalog
     * @return bool|\yii\db\ActiveRecord|ShopCatalog|null
     */            
    public function getShopCatalogOne()
    {
        return $this->getOne(ShopCatalog::class, [
          'id' => 'shop_catalog_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCatalog
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCatalog()
    {
        return $this->hasOne(ShopCatalog::class, [
          'id' => 'shop_catalog_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getShopCatalogWare
     * @return bool|\yii\db\ActiveRecord|ShopCatalogWare|null
     */            
    public function getShopCatalogWareOne()
    {
        return $this->getOne(ShopCatalogWare::class, [
          'id' => 'shop_catalog_ware_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCatalogWare
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCatalogWare()
    {
        return $this->hasOne(ShopCatalogWare::class, [
          'id' => 'shop_catalog_ware_id',
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



    #endregion
    
    #region Many



    #endregion


}

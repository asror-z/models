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
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\user\User;
use zetsoft\models\user\UserCompany;
use zetsoft\models\ware\WareEnterItem;
use zetsoft\models\ware\WareExitItem;
use zetsoft\models\ware\WareTransItem;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopCatalog
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $guid
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_company_id
 * @property int $parent
 * @property int $shop_element_id
 * @property string $currency
 * @property int $price
 * @property int $amount
 * @property boolean $available
 * @property int $price_old
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopCatalog extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $guid;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $user_company_id;
    public $parent;
    public $shop_element_id;
    public $currency;
    public $price;
    public $amount;
    public $available;
    public $price_old;
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
        'guid',
        'title',
        'tranz',
        'accept',
        'active',
        'user_company_id',
        'parent',
        'shop_element_id',
        'currency',
        'price',
        'amount',
        'available',
        'price_old',
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

    /* @var array $_currency*/
    public $_currency;  
    public const currency = [
        'USD' => 'USD',
        'EUR' => 'EUR',
        'UZS' => 'UZS',
        'RUB' => 'RUB',
        'GBP' => 'GBP',
        'JPY' => 'JPY',
        'BHD' => 'BHD',
        'CAD' => 'CAD',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Каталог магазина';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_currency = [
            'USD' => Az::l('USD (Доллар США)'),
            'EUR' => Az::l('EUR (Евро)'),
            'UZS' => Az::l('UZS (Узбекский сум)'),
            'RUB' => Az::l('RUB (Российский рубль)'),
            'GBP' => Az::l('GBP (Фунт стерлингов)'),
            'JPY' => Az::l('JPY (Иена)'),
            'BHD' => Az::l('BHD (Бахрейнский динар)'),
            'CAD' => Az::l('CAD (Канадский долла)'),
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
			'guid',
			'title',
			'tranz',
			'accept',
			'active',
			'user_company_id',
			'parent',
			'shop_element_id',
			'currency',
			'price',
			'amount',
			'available',
			'price_old',
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

            $config->addGuid = true;
            $config->guidAuto = true;
                                                                                                                                    $config->nameValue = function ($model) {

                /** @var ShopCatalog $model */
                $company = UserCompany::findOne($model->user_company_id);
                $element = ShopElement::findOne($model->shop_element_id);

                if (!$element)
                    return false;

                if (!$company)
                    return false;

                return $element->name . ' ' . $model->price . ' от ' . $company->name . '№' . $model->id;

            };

                                                                                                                                    $config->guidValue = function ($model) {
                return Az::$app->cores->guid->create();
            };

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
                    'ShopCatalog' => [
                        'parent' => 'id',
                    ],
                    'ShopElement' => [
                        'shop_element_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopCatalog' => [
                        'parent' => 'id',
                    ],
                    'ShopCatalogWare' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'ShopOffer' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'ShopOrderItem' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'WareEnterItem' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'WareExitItem' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'WareTransItem' => [
                        'shop_catalog_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Каталог магазина');

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

                $column->index = true;
                $column->title = Az::l('Магазин');
                $column->tooltip = Az::l('Магазин товара');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                $column->fkQuery = [
                    'type' => 'market',
                ];

                return $column;
            },


            'parent' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящий');
                $column->tooltip = Az::l('Связанный вышестоящий заказ');
                /*$column->dbType = dbTypeInteger;*/
                //$column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                    ],
                ];
                $column->fkTable = 'shop_catalog';

                return $column;
            },


            'shop_element_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Элементы продукта');
                $column->tooltip = Az::l('Доступные элементы продукта ');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                /*$column->options = [
                    'config' => [
                        'depend' => 'user_company_id',
                        'method' => 'getElementsByUserCompany',
                    ],
                ];*/
                $column->width = '400px';

                return $column;
            },


            'currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта');
                $column->tooltip = Az::l('Все доступные валюты');
                $column->value = 'UZS';
                $column->data = [
                    'USD' => Az::l('USD (Доллар США)'),
                    'EUR' => Az::l('EUR (Евро)'),
                    'UZS' => Az::l('UZS (Узбекский сум)'),
                    'RUB' => Az::l('RUB (Российский рубль)'),
                    'GBP' => Az::l('GBP (Фунт стерлингов)'),
                    'JPY' => Az::l('JPY (Иена)'),
                    'BHD' => Az::l('BHD (Бахрейнский динар)'),
                    'CAD' => Az::l('CAD (Канадский долла)'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'price' => function (FormDb $column) {

                $column->title = Az::l('Цена');
                $column->tooltip = Az::l('Цена товара за 1 шт.');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;
                return $column;
            },


            'amount' => function (FormDb $column) {

                $column->title = Az::l('Количество');
                $column->tooltip = Az::l('Общее количество товара');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },


            'available' => function (FormDb $column) {

                $column->title = Az::l('В наличии');
                $column->tooltip = Az::l('Есть ли данный товар в наличии');
                $column->dbType = dbTypeBoolean;
                $column->value = true;
                $column->rules = validatorBoolean;
                $column->widget = ZKSwitchInputWidget::class;
                $column->mergeHeader = true;

                return $column;
            },


            'price_old' => function (FormDb $column) {

                $column->title = Az::l('Старая цена');
                $column->tooltip = Az::l('Старая цена данного товара');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKTouchSpinWidget::class;

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
        'guid',
        'title',
        'tranz',
        'accept',
        'active',
        'user_company_id',
        'parent',
        'shop_element_id',
        'currency',
        'price',
        'amount',
        'available',
        'price_old',
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
                                'guid',
                                'title',
                                'tranz',
                                'accept',
                                'active',
                                'user_company_id',
                                'parent',
                                'shop_element_id',
                                'currency',
                                'price',
                                'amount',
                                'available',
                                'price_old',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopCatalog $model = null)
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
     * Function  getParent
     * @return bool|\yii\db\ActiveRecord|ShopCatalog|null
     */            
    public function getParentOne()
    {
        return $this->getOne(ShopCatalog::class, [
          'id' => 'parent',
      ]);    
    }
    
     /**
     *
     * Function  getParent
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getParent()
    {
        return $this->hasOne(ShopCatalog::class, [
          'id' => 'parent',
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


    /**
     *
     * Function  getShopCatalogsWithParentMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCatalog
     */            
    public function getShopCatalogsWithParentMany()
    {
       return $this->getMany(ShopCatalog::class, [
            'parent' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCatalogsWithParent
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCatalogsWithParent()
    {
       return $this->hasMany(ShopCatalog::class, [
            'parent' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopCatalogWaresWithShopCatalogIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopCatalogWare
     */            
    public function getShopCatalogWaresWithShopCatalogIdMany()
    {
       return $this->getMany(ShopCatalogWare::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopCatalogWaresWithShopCatalogId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopCatalogWaresWithShopCatalogId()
    {
       return $this->hasMany(ShopCatalogWare::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopOffersWithShopCatalogIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOffer
     */            
    public function getShopOffersWithShopCatalogIdMany()
    {
       return $this->getMany(ShopOffer::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOffersWithShopCatalogId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOffersWithShopCatalogId()
    {
       return $this->hasMany(ShopOffer::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getShopOrderItemsWithShopCatalogIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrderItem
     */            
    public function getShopOrderItemsWithShopCatalogIdMany()
    {
       return $this->getMany(ShopOrderItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrderItemsWithShopCatalogId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrderItemsWithShopCatalogId()
    {
       return $this->hasMany(ShopOrderItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareEnterItemsWithShopCatalogIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnterItem
     */            
    public function getWareEnterItemsWithShopCatalogIdMany()
    {
       return $this->getMany(WareEnterItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEnterItemsWithShopCatalogId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEnterItemsWithShopCatalogId()
    {
       return $this->hasMany(WareEnterItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareExitItemsWithShopCatalogIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExitItem
     */            
    public function getWareExitItemsWithShopCatalogIdMany()
    {
       return $this->getMany(WareExitItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitItemsWithShopCatalogId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitItemsWithShopCatalogId()
    {
       return $this->hasMany(WareExitItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareTransItemsWithShopCatalogIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareTransItem
     */            
    public function getWareTransItemsWithShopCatalogIdMany()
    {
       return $this->getMany(WareTransItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareTransItemsWithShopCatalogId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareTransItemsWithShopCatalogId()
    {
       return $this->hasMany(WareTransItem::class, [
            'shop_catalog_id' => 'id',
        ]);     
    }


    #endregion


}

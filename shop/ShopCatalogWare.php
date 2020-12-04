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
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\dbitem\shop\ProductItem;
use zetsoft\former\shop\ShopOfferForm;
use zetsoft\models\shop\ShopElement;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareExitItem;
use zetsoft\models\ware\WareTransItem;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\WareEnterItem;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopCatalogWare
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_catalog_id
 * @property int $ware_id
 * @property string $best_before
 * @property int $amount
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopCatalogWare extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $shop_catalog_id;
    public $ware_id;
    public $best_before;
    public $amount;
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
        'title',
        'tranz',
        'accept',
        'active',
        'shop_catalog_id',
        'ware_id',
        'best_before',
        'amount',
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
    public static ?string $title = Azl . 'Каталог магазина распределенный по складам';
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
			'title',
			'tranz',
			'accept',
			'active',
			'shop_catalog_id',
			'ware_id',
			'best_before',
			'amount',
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

            $config->addName = false;
            $config->hasOne = [
                    'ShopCatalog' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'Ware' => [
                        'ware_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'WareEnterItem' => [
                        'shop_catalog_ware_id' => 'id',
                    ],
                    'WareExitItem' => [
                        'shop_catalog_ware_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Каталог магазина распределенный по складам');

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
           
            'shop_catalog_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог магазина');
                $column->tooltip = Az::l('Каталог магазина');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад');
                $column->tooltip = Az::l('Склад в котором хранится данный каталог товаров');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'best_before' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Годен до');
                $column->tooltip = Az::l('Срок годности данного каталога товаров');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;

                return $column;
            },
            
           
            'amount' => function (FormDb $column) {

                $column->title = Az::l('Колличество');
                $column->tooltip = Az::l('Количество товаров доступное в складе');
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
                $column->history = true;

                return $column;
            },
            

        ], $this->configs->replace);
    }



    #endregion


    #region Props

    /*

    
        'id',
        'sort',
        'title',
        'tranz',
        'accept',
        'active',
        'shop_catalog_id',
        'ware_id',
        'best_before',
        'amount',
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
                                'shop_catalog_id',
                                'ware_id',
                                'amount',
                                'best_before',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopCatalogWare $model = null)
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
//
//        $event->beforeSave = function (ShopCatalog $model) {
//        };

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
     * Function  getWare
     * @return bool|\yii\db\ActiveRecord|Ware|null
     */            
    public function getWareOne()
    {
        return $this->getOne(Ware::class, [
          'id' => 'ware_id',
      ]);    
    }
    
     /**
     *
     * Function  getWare
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWare()
    {
        return $this->hasOne(Ware::class, [
          'id' => 'ware_id',
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
     * Function  getWareEnterItemsWithShopCatalogWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareEnterItem
     */            
    public function getWareEnterItemsWithShopCatalogWareIdMany()
    {
       return $this->getMany(WareEnterItem::class, [
            'shop_catalog_ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareEnterItemsWithShopCatalogWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareEnterItemsWithShopCatalogWareId()
    {
       return $this->hasMany(WareEnterItem::class, [
            'shop_catalog_ware_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareExitItemsWithShopCatalogWareIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExitItem
     */            
    public function getWareExitItemsWithShopCatalogWareIdMany()
    {
       return $this->getMany(WareExitItem::class, [
            'shop_catalog_ware_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitItemsWithShopCatalogWareId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitItemsWithShopCatalogWareId()
    {
       return $this->hasMany(WareExitItem::class, [
            'shop_catalog_ware_id' => 'id',
        ]);     
    }


    #endregion


}

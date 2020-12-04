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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\shop\ShopOfferForm;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\validate\ExitItemCountValidator;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\models\shop\ShopElement;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopOffer;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\WareExit;
use zetsoft\models\ware\WareSeries;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareExitItem
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $ware_exit_id
 * @property int $shop_catalog_id
 * @property string $best_before
 * @property int $ware_series_id
 * @property int $amount
 * @property double $weight
 * @property int $shop_catalog_ware_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareExitItem extends ZActiveRecord
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
    public $ware_exit_id;
    public $shop_catalog_id;
    public $best_before;
    public $ware_series_id;
    public $amount;
    public $weight;
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
        'ware_exit_id',
        'shop_catalog_id',
        'best_before',
        'ware_series_id',
        'amount',
        'weight',
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

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Элемент списания товара из склада';
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
			'ware_exit_id',
			'shop_catalog_id',
			'best_before',
			'ware_series_id',
			'amount',
			'weight',
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

            $config->nameValue = 'Списание-{id} от {created_at}';

            $config->hasOne = [
                    'WareExit' => [
                        'ware_exit_id' => 'id',
                    ],
                    'ShopCatalog' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'WareSeries' => [
                        'ware_series_id' => 'id',
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
            $config->title = Az::l('Элемент списания товара из склада');

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
           
            'ware_exit_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Акт списания товаров');
                $column->tooltip = Az::l('Номер акта для списания товаров со склада');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'shop_catalog_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог товаров');
                $column->tooltip = Az::l('Каталог товаров списывающихся со склада');
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'best_before' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Годен до');
                $column->tooltip = Az::l('Список срока годности выбранного каталога товаров для списания со склада');
                $column->dbType = dbTypeDate;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator'
                    ]
                ];
                $column->widget = ZDepdropWidget::class;
                $column->options = [
						'config' =>[
							'depend' => 'shop_catalog_id',
							'namespace' => 'inputs',
							'service' => 'depend',
							'method' => 'shelfLifeByCatalogId',
						],
					];

                return $column;
            },
            
           
            'ware_series_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Серия');
                $column->tooltip = Az::l('Серия выбранного каталога товаров');
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
						'config' =>[
							'tags' => true,
						],
					];

                return $column;
            },
            
           
            'amount' => function (FormDb $column) {

                $column->title = Az::l('Количество');
                $column->tooltip = Az::l('Количество отгруженных товаров');
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
            
           
            'weight' => function (FormDb $column) {

                $column->title = Az::l('Вес');
                $column->tooltip = Az::l('Вес списывающихся товаров');
                $column->dbType = dbTypeDouble;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },
            
           
            'shop_catalog_ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Каталог магазина распределенный по складам');
                $column->tooltip = Az::l('Каталог магазина распределенный по складам');
                $column->widget = ZKSelect2Widget::class;
                $column->readonly = true;
                $column->auto = true;
                $column->autoValue = function (WareExitItem $model){
                     $ware_exit = WareExit::findOne($model->ware_exit_id);
                     if ($ware_exit === null)
                     return null;

                     $shop_catalog_ware = ShopCatalogWare::find()
                        ->where([
                            'ware_id' => $ware_exit->ware_id,
                            'shop_catalog_id' => $model->shop_catalog_id
                        ])
                        ->one();

                        if (empty($shop_catalog_ware))
                            return null;

                        return $shop_catalog_ware->id;
                };
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
        'ware_exit_id',
        'shop_catalog_id',
        'best_before',
        'ware_series_id',
        'amount',
        'weight',
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
                                'name',
                                'ware_exit_id',
                            ],
                            [
                                'shop_catalog_id',
                                'ware_series_id',
                            ],
                            [
                                'best_before',
                                'amount',
                                'weight',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareExitItem $model = null)
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

        $event->beforeSave = function (WareExitItem $model) {
                
            if ($this->isNewRecord) {
                Az::$app->market->wares->wareExit($model);
            } else {
                Az::$app->market->wares->editWareExit($model);
            }
                
        };

        /*$event->afterDelete = function (WareExitItem $model) {
            Az::$app->market->wares->wareEnter($model);
        };*/
        
        /*
        $event->beforeDelete = function (ShopCatalog $model) {
        return null;
        };

        $event->afterDelete = function (ShopCatalog $model) {
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
     * Function  getWareExit
     * @return bool|\yii\db\ActiveRecord|WareExit|null
     */            
    public function getWareExitOne()
    {
        return $this->getOne(WareExit::class, [
          'id' => 'ware_exit_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareExit
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareExit()
    {
        return $this->hasOne(WareExit::class, [
          'id' => 'ware_exit_id',
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

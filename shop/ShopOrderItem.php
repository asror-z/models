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


use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\place\PlaceRegion;
use zetsoft\system\validate\ZRequiredValidator;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\user\UserCompany;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareReturn;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\dbitem\data\Config;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopOrderItem
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_order_id
 * @property int $ware_id
 * @property int $user_company_id
 * @property int $shop_catalog_id
 * @property string $best_before
 * @property int $ware_return_id
 * @property int $amount
 * @property int $amount_partial
 * @property string $amount_return
 * @property string $price
 * @property int $price_all
 * @property string $price_all_partial
 * @property string $price_all_return
 * @property boolean $accepted
 * @property boolean $check_return
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopOrderItem extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $tranz;
    public $accept;
    public $active;
    public $shop_order_id;
    public $ware_id;
    public $user_company_id;
    public $shop_catalog_id;
    public $best_before;
    public $ware_return_id;
    public $amount;
    public $amount_partial;
    public $amount_return;
    public $price;
    public $price_all;
    public $price_all_partial;
    public $price_all_return;
    public $accepted;
    public $check_return;
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
        'tranz',
        'accept',
        'active',
        'shop_order_id',
        'ware_id',
        'user_company_id',
        'shop_catalog_id',
        'best_before',
        'ware_return_id',
        'amount',
        'amount_partial',
        'amount_return',
        'price',
        'price_all',
        'price_all_partial',
        'price_all_return',
        'accepted',
        'check_return',
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
    public static ?string $title = Azl . 'Товары заказа';
    public static ?string $icon = 'fal fa-save';
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
			'tranz',
			'accept',
			'active',
			'shop_order_id',
			'ware_id',
			'user_company_id',
			'shop_catalog_id',
			'best_before',
			'ware_return_id',
			'amount',
			'amount_partial',
			'amount_return',
			'price',
			'price_all',
			'price_all_partial',
			'price_all_return',
			'accepted',
			'check_return',
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

            $config->addTitle = false;
                                                                                                                                                                                    $config->nameValue = static function (ShopOrderItem $model) {

                Az::$app->forms->wiData->clean();
                Az::$app->forms->wiData->model = $model;
                Az::$app->forms->wiData->attribute = 'shop_catalog_id';
                $shop_catalog = Az::$app->forms->wiData->value();
                $orderId = $model->shop_order_id;


                return "$shop_catalog от заказа №$orderId №$model->id";
            };

            $config->hasOne = [
                    'ShopOrder' => [
                        'shop_order_id' => 'id',
                    ],
                    'Ware' => [
                        'ware_id' => 'id',
                    ],
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'ShopCatalog' => [
                        'shop_catalog_id' => 'id',
                    ],
                    'WareReturn' => [
                        'ware_return_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->icon = 'fal fa-save';

            $config->title = Az::l('Товары заказа');

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

            'shop_order_id' => function (FormDb $column) {

                $column->title = Az::l('Идентификатор заказа');
                $column->tooltip = Az::l('Идентификатор заказа для данного товара');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->width = '270px';
                $column->index = true;
                $column->icon = 'fa fa-save';
                $column->rules = ZRequiredValidator::class;


                return $column;
            },


            'ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад');
                $column->tooltip = Az::l('Склад откуда выходит товар');
                $column->dbType = dbTypeInteger;
                $column->changeSave = true;
                $column->changeReload = true;
                $column->widget = ZKSelect2Widget::class;
                $column->readonly = false;

                return $column;
            },

            'user_company_id' => function (FormDb $column) {

                $column->title = Az::l('Магазин');
                $column->tooltip = Az::l('Магазин откуда заказывается товар');

                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'market',
                ];

                return $column;
            },

            'shop_catalog_id' => function (FormDb $column) {

                $column->title = Az::l('Каталог товаров');
                $column->tooltip = Az::l('Каталог доступных товаров');
                $column->dbType = dbTypeInteger;
                $column->changeSave = true;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->width = '270px';
                //   $column->widget = ZDepdropWidget::class;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'user_company_id',
                        'method' => 'getCompaniesCatalog'
                    ]
                ];

                return $column;
            },


            'best_before' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Срок годности');
                $column->tooltip = Az::l('Срок годности товара');
                $column->dbType = dbTypeDate;
                $column->widget = ZDepdropWidget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'shop_catalog_id',
                        'namespace' => 'inputs',
                        'service' => 'depend',
                        'method' => 'shelfLifeByCatalogId',
                    ],
                ];

                return $column;
            },

            'ware_return_id' => function (FormDb $column) {

                $column->title = Az::l('Возврат');
                $column->tooltip = Az::l('Возврат в котором подобран данный товар');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'amount' => function (FormDb $column) {

                $column->title = Az::l('Количество');
                $column->tooltip = Az::l('Количество отгруженных товаров');
                $column->dbType = dbTypeInteger;

                $column->pageSummary = true;
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

            'amount_partial' => function (FormDb $column) {


                $column->title = Az::l('Купленное количество');
                $column->tooltip = Az::l('Купленное количество товаров клиентом');
                $column->widget = ZKTouchSpinWidget::class;
                $column->dbType = dbTypeInteger;
                $column->pageSummary = true;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },

            'amount_return' => function (FormDb $column) {

                $column->title = Az::l('Количество возвращенных товаров');
                $column->tooltip = Az::l('Количество возвращенных товаров клиентом');
                $column->widget = ZKTouchSpinWidget::class;
                $column->readonly = true;
                $column->pageSummary = true;

                return $column;
            },

            'price' => function (FormDb $column) {

                $column->title = Az::l('Cумма одного товара');
                $column->tooltip = Az::l('Cумма одного товара');
                $column->widget = ZKTouchSpinWidget::class;

                return $column;
            },

            'price_all' => function (FormDb $column) {

                $column->title = Az::l('Cумма товаров');
                $column->tooltip = Az::l('Общая сумма товаров');
                $column->dbType = dbTypeInteger;
                $column->pageSummary = true;
                $column->rules = validatorInteger;
                $column->widget = ZKTouchSpinWidget::class;
                $column->auto = true;
                /*$column->autoValue = function (ShopOrderItem $model) {

                    $gg = new ZView();
                    $discAmount = DiscAmount::find()
                        ->where([
                            'shop_catalog_ids' => $model->shop_catalog_id
                        ])
                        ->all();

                    $return = null;
                    if (!$gg->emptyOrNullable($discAmount)) {
                        foreach ($discAmount as $item) {
                            if ($item->min_amount <= $model->amount && $item->max_amount >= $model->amount) {
                                switch ($item->kind) {
                                    case DiscAmount::kind['percent']:
                                        $return = (($model->price / 100) * $item->number) * $model->amount;
                                        break;
                                    case DiscAmount::kind['sum']:
                                        $return = $model->amount * $item->number;
                                        break;
                                }

                            }
                        }
                    } else {
                        $return = (int)$model->amount * (int)$model->price;
                    }
                    return $return;
                };*/

                return $column;
            },

            'price_all_partial' => function (FormDb $column) {

                $column->title = Az::l('Cумма купленных товаров');
                $column->tooltip = Az::l('Общая сумма купленных товаров клиентом');
                $column->widget = ZKTouchSpinWidget::class;
                $column->pageSummary = true;
                $column->auto = true;
                /*$column->autoValue = function (ShopOrderItem $model) {
                    $return = null;
                    $gg = new ZView();

                    $discAmount = DiscAmount::find()
                        ->where([
                            'shop_catalog_ids' => $model->shop_catalog_id
                        ])
                        ->all();

                    if (!$gg->emptyOrNullable($discAmount)) {
                        foreach ($discAmount as $item) {
                            if ($item->min_amount <= $model->amount_partial && $item->max_amount >= $model->amount_partial) {

                                switch ($item->kind) {
                                    case DiscAmount::kind['percent']:
                                        $return = (($model->price / 100) * $item->number) * $model->amount_partial;
                                        break;
                                    case DiscAmount::kind['sum']:
                                        $return = $model->amount_partial * $item->number;
                                        break;
                                }

                            }
                        }
                    } else {

                    }
                    return $return;
                };*/

                return $column;
            },

            'price_all_return' => function (FormDb $column) {

                $column->title = Az::l('Cумма возвращенных товаров');
                $column->tooltip = Az::l('Общая сумма возвращенных товаров клиентом');
                $column->widget = ZKTouchSpinWidget::class;
                $column->pageSummary = true;
                $column->auto = true;

                return $column;
            },

            'accepted' => function (FormDb $column) {

                $column->title = Az::l('Принят');
                $column->dbType = dbTypeBoolean;

                return $column;
            },

            'check_return' => function (FormDb $column) {

                $column->title = Az::l('Возврат?');
                $column->tooltip = Az::l('Добавлено ли данный товар в возврат товаров?');
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
        'sort',
        'name',
        'tranz',
        'accept',
        'active',
        'shop_order_id',
        'ware_id',
        'user_company_id',
        'shop_catalog_id',
        'best_before',
        'ware_return_id',
        'amount',
        'amount_partial',
        'amount_return',
        'price',
        'price_all',
        'price_all_partial',
        'price_all_return',
        'accepted',
        'check_return',
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
                                'shop_order_id',
                                'ware_id',
                            ],
                            [
                                'user_company_id',
                                'shop_catalog_id',
                            ],
                            [
                                'ware_return_id',
                                'amount',
                            ],
                            [
                                'amount_partial',
                                'amount_return',
                            ],
                            [
                                'price',
                                'price_all',
                            ],
                            [
                                'price_all_partial',
                                'price_all_return',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopOrderItem $model = null)
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

        $event->beforeSave = function (ShopOrderItem $model) {

            $shop_order = ShopOrder::findOne($model->shop_order_id);

            if ($shop_order === null)
                return null;

            //    vd($shop_order->attributes);
            if ($this->isNewRecord) {

                //tekwiriw kere
                $ware_id = $model->ware_id;
                if ($shop_order && empty($model->ware_id)) {
                    $place_region = PlaceRegion::findOne($shop_order->place_region_id);
                    if ($place_region) {
                        $ware_id = $place_region->ware_id;
                    }
                }


                /*
                                if ($shop_order) {
                                    $place_region = PlaceRegion::findOne($shop_order->place_region_id);
                                    if ($place_region) {
                                        $model->ware_id = $place_region->ware_id;
                                    }
                                }*/
                //end
                $model->ware_id = $ware_id;

                $shopCatalog = ShopCatalog::findOne($model->shop_catalog_id);

                $price = $model->price;
                if ($shopCatalog)
                    $price = $shopCatalog->price;

                $model->price = $price;

                if (empty($model->price_all)) {
                    $model->price_all = (int)$model->price * (int)$model->amount;
                }

                $model->amount_partial = (int)$model->amount;
                $model->price_all_partial = (int)$model->amount_partial * (int)$model->price;

            }


            if (empty($model->amount_partial) || $model->amount_partial > $model->amount) {
                if ((int)$model->amount_partial !== 0) {
                    $model->amount_partial = $model->amount;
                }
            }

            $model->price_all = (int)$model->price * (int)$model->amount;

            $model->price_all_partial = (int)$model->amount_partial * (int)$model->price;
            $model->amount_return = (int)$model->amount - (int)$model->amount_partial;
            $model->price_all_return = (int)$model->price * (int)$model->amount_return;

            //  return null;

            $shop_order->value($shop_order);

        };

        $event->afterSave = function (ShopOrderItem $model) {

            Az::$app->market->wares->addInfo($model->shop_order_id);
        };

        /* $event->afterDelete = static function (ShopOrderItem $model) {
             Az::$app->market->wares->addInfo($model->shop_order_id);
         };
        
        $event->beforeDelete = function (ShopOrderItem $model) {
        return null;
        };

        $event->afterDelete = function (ShopOrderItem $model) {
        return null;
        };

        $event->beforeValidate = function (ShopOrderItem $model) {
        return null;
        };

        $event->afterValidate = function (ShopOrderItem $model) {
        return null;
        };

        $event->afterRefresh = function (ShopOrderItem $model) {
        return null;
        };

        $event->afterFind = function (ShopOrderItem $model) {
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
     * Function  getShopOrder
     * @return bool|\yii\db\ActiveRecord|ShopOrder|null
     */            
    public function getShopOrderOne()
    {
        return $this->getOne(ShopOrder::class, [
          'id' => 'shop_order_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopOrder
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopOrder()
    {
        return $this->hasOne(ShopOrder::class, [
          'id' => 'shop_order_id',
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
     * Function  getWareReturn
     * @return bool|\yii\db\ActiveRecord|WareReturn|null
     */            
    public function getWareReturnOne()
    {
        return $this->getOne(WareReturn::class, [
          'id' => 'ware_return_id',
      ]);    
    }
    
     /**
     *
     * Function  getWareReturn
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getWareReturn()
    {
        return $this->hasOne(WareReturn::class, [
          'id' => 'ware_return_id',
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

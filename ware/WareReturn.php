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
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopCatalogWare;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\kernels\ZView;
use zetsoft\system\validate\IdenticalValidator;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\UserCompany;
use zetsoft\models\shop\ShopCatalog;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareTransItem;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    WareReturn
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $date
 * @property array $shop_order_ids
 * @property string $comment
 * @property int $shop_courier_id
 * @property int $responsible
 * @property int $total_price
 * @property int $ware_id
 * @property string $status
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class WareReturn extends ZActiveRecord
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
    public $date;
    public $shop_order_ids;
    public $comment;
    public $shop_courier_id;
    public $responsible;
    public $total_price;
    public $ware_id;
    public $status;
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
        'date',
        'shop_order_ids',
        'comment',
        'shop_courier_id',
        'responsible',
        'total_price',
        'ware_id',
        'status',
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

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'new' => 'new',
        'courier' => 'courier',
        'delivered' => 'delivered',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Возврат товаров от клиентов';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'new' => Az::l('Новый'),
            'courier' => Az::l('Присвоен курьеру'),
            'delivered' => Az::l('Доставлен'),
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
			'date',
			'shop_order_ids',
			'comment',
			'shop_courier_id',
			'responsible',
			'total_price',
			'ware_id',
			'status',
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

            $config->nameValue = 'Возврат товаров №{id}';

            $config->hasOne = [
                    'ShopCourier' => [
                        'shop_courier_id' => 'id',
                    ],
                    'User' => [
                        'responsible' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'Ware' => [
                        'ware_id' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'ShopOrder' => [
                        'shop_order_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopOrderItem' => [
                        'ware_return_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Возврат товаров от клиентов');

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

            'date' => function (FormDb $column) {

                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания возврата товаров');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                $column->showDyna = false;
                $column->readonlyWidget = true;
                return $column;
            },


            'shop_order_ids' => function (FormDb $column) {

                $column->title = Az::l('Идентификатор заказов');
                $column->tooltip = Az::l('Идентификатор заказов для которых производится возврат');
                $column->dbType = dbTypeJsonb;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'multiple' => true
                    ]
                ];
                /*$column->options = static function () {
                    $view = new ZView();
                    if ($view->tableExists('shop_order')) {
                        $orders = ShopOrder::find()
                            ->where([
                                'status_logistics' => ShopOrder::status_logistics['completed']
                            ])
                            ->all();

                        $return = [];
                        foreach ($orders as $order) {
                            if (!empty(Az::$app->inputs->depend->getCouriersByOrderId($order->id))) {
                                $return[$order->id] = $order->name;
                            }
                        }

                        return [
                            'data' => $return,
                            'config' => [
                                'multiple' => true
                            ]
                        ];
                    }

                };*/

                return $column;
            },


            'comment' => function (FormDb $column) {

                $column->title = Az::l('Комментарий');
                $column->tooltip = Az::l('Комментарий к документу возврата товаров');
                $column->dbType = dbTypeText;
                $column->widget = ZHTextareaWidget::class;
                $column->filterWidget = ZInputWidget::class;

                return $column;
            },


            'shop_courier_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Курьер');
                $column->tooltip = Az::l('Курьер который осуществляет возврат');
                $column->dbType = dbTypeInteger;
                $column->widget = ZDepdropWidget::class;
                $column->filterWidget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'shop_order_ids',
                        'method' => 'getCouriersByOrderId',
                    ],
                ];

                return $column;
            },


            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->tooltip = Az::l('Ответственное лицо создавшее документ возврата товаров');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'user';
                $column->fkQuery = [
                    'role' => [
                        'manager',
                        'admin',
                        'logistics',
                        'warehouse',
                    ],
                ];

                return $column;
            },


            'total_price' => function (FormDb $column) {

                $column->title = Az::l('Сумма');
                $column->tooltip = Az::l('Общая сумма возвращенных товаров');
                $column->dbType = dbTypeInteger;
                $column->readonly = true;

                return $column;
            },


            'ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Склад');
                $column->tooltip = Az::l('Склад в которую отправляется возвращенный товар');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'status' => function (FormDb $column) {

                $column->defaultValue = 'new';
                $column->title = Az::l('Статус');
                $column->tooltip = Az::l('Статус возврата товаров');
                $column->data = [
                    'new' => Az::l('Новый'),
                    'courier' => Az::l('Присвоен курьеру'),
                    'delivered' => Az::l('Доставлен'),
                ];
                $column->widget = ZKSelect2Widget::class;
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
        'name',
        'title',
        'tranz',
        'accept',
        'active',
        'date',
        'shop_order_ids',
        'comment',
        'shop_courier_id',
        'responsible',
        'total_price',
        'ware_id',
        'status',
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
                                'date',
                                'responsible',
                                'shop_order_ids',
                                'comment',
                                'shop_courier_id',
                                'total_price',
                                'ware_id',
                                'status',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(WareReturn &$model = null)
    {
        if ($model === null)
            $model = $this;

        // Todo: MyCode

        $model->save();
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
        //start|MurodovMirbosit|22.10.2020
        $event->beforeSave = function (WareReturn $model) {
            $shop_order_ids = $model->shop_order_ids;
            $shop_order_items = ShopOrderItem::find()
                ->where([
                    'shop_order_id' => $shop_order_ids,
                ])->all();

            $price = 0;

            /** @var ShopOrderItem $shop_order_item */
            foreach ($shop_order_items as $shop_order_item) {
                $price += (int)$shop_order_item->price_all_partial;
            }
            
            $model->total_price = $price;

            Az::$app->market->wares->getReturnIdByOrderItem($model);
        };
        //end|MurodovMirbosit|22.10.2020
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
     * Function  getShopCourier
     * @return bool|\yii\db\ActiveRecord|ShopCourier|null
     */            
    public function getShopCourierOne()
    {
        return $this->getOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
     /**
     *
     * Function  getShopCourier
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getShopCourier()
    {
        return $this->hasOne(ShopCourier::class, [
          'id' => 'shop_courier_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getResponsible
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getResponsibleOne()
    {
        return $this->getOne(User::class, [
          'id' => 'responsible',
      ]);    
    }
    
     /**
     *
     * Function  getResponsible
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getResponsible()
    {
        return $this->hasOne(User::class, [
          'id' => 'responsible',
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
    
    


    #endregion

    #region Multi


    /**
     *
     * Function  getShopOrdersFromShopOrderIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|ShopOrder
     */            
    public function getShopOrdersFromShopOrderIdsMulti()
    {
        return $this->getMulti(ShopOrder::class, [
          'id' => 'shop_order_ids',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getShopOrderItemsWithWareReturnIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrderItem
     */            
    public function getShopOrderItemsWithWareReturnIdMany()
    {
       return $this->getMany(ShopOrderItem::class, [
            'ware_return_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrderItemsWithWareReturnId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrderItemsWithWareReturnId()
    {
       return $this->hasMany(ShopOrderItem::class, [
            'ware_return_id' => 'id',
        ]);     
    }


    #endregion


}

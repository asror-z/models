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


use Underscore\Types\Number;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\user\User;
use zetsoft\models\ware\WareAccept;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZHTextareaWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\shop\ShopCourier;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopShipment
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $code
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $date
 * @property string $date_deliver
 * @property string $shipment_type
 * @property int $shop_courier_id
 * @property int $responsible
 * @property string $comment
 * @property array $ware_place_ids
 * @property array $user_place_ids
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopShipment extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $code;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $date;
    public $date_deliver;
    public $shipment_type;
    public $shop_courier_id;
    public $responsible;
    public $comment;
    public $ware_place_ids;
    public $user_place_ids;
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
        'code',
        'title',
        'tranz',
        'accept',
        'active',
        'date',
        'date_deliver',
        'shipment_type',
        'shop_courier_id',
        'responsible',
        'comment',
        'ware_place_ids',
        'user_place_ids',
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

    /* @var array $_shipment_type*/
    public $_shipment_type;  
    public const shipment_type = [
        'based_on_table' => 'based_on_table',
        'express' => 'express',
        'international' => 'international',
        'local' => 'local',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Доставка заказов';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_shipment_type = [
            'based_on_table' => Az::l('Стандарт'),
            'express' => Az::l('Экспресс'),
            'international' => Az::l('Международный'),
            'local' => Az::l('Местный'),
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
			'code',
			'title',
			'tranz',
			'accept',
			'active',
			'date',
			'date_deliver',
			'shipment_type',
			'shop_courier_id',
			'responsible',
			'comment',
			'ware_place_ids',
			'user_place_ids',
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

            $config->addDel = 1;

            $config->addCode = 1;

            $config->titleId = 'Номер';

            $config->nameValue = 'Передача заказов в подотчет курьеру {id} от {created_at}';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $config->codeValue = function (ShopShipment $model) {
                return Number::paddingLeft($model->id, 12);
            };

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
                ];
            $config->hasMulti = [
                    'WarePlace' => [
                        'ware_place_ids' => 'id',
                    ],
                    'UserPlace' => [
                        'user_place_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopOrder' => [
                        'shop_shipment_id' => 'id',
                    ],
                    'WareAccept' => [
                        'shop_shipment_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Доставка заказов');

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
                $column->tooltip = Az::l('Дата создания');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                $column->options = [
                    'config' => [
                        'disabled' => true,
                    ],
                ];

                return $column;
            },

            'date_deliver' => function (FormDb $column) {

                $column->title = Az::l('Дата доставки');
                $column->tooltip = Az::l('Дата доставки заказа');
                $column->dbType = dbTypeDate;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKDatepickerWidget::class;
                $column->options = [
                  'config' => [
                    'startDate' => '0'
                  ]
                ];
                $column->history = true;

                return $column;
            },


            'shipment_type' => function (FormDb $column) {

                $column->defaultValue = false;
                $column->title = Az::l('Тип доставки');
                $column->tooltip = Az::l('осуществляемые типы доставки');
                $column->data = [
                    'based_on_table' => Az::l('Стандарт'),
                    'express' => Az::l('Экспресс'),
                    'international' => Az::l('Международный'),
                    'local' => Az::l('Местный'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'shop_courier_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Курьер');
                $column->tooltip = Az::l('Курьер');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'shop_courier';

                return $column;
            },


            'responsible' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Ответственный');
                $column->tooltip = Az::l('Ответственный заказа');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
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


            'comment' => function (FormDb $column) {

                $column->title = Az::l('Комментарий');
                $column->tooltip = Az::l('Комментарий');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZHTextareaWidget::class;
                $column->filterWidget = ZInputWidget::class;

                return $column;
            },


            'ware_place_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Расположения складов');
                $column->tooltip = Az::l('Расположения складов');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'multiple' => true,
                    ],
                ];

                return $column;
            },


            'user_place_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Расположения клиентов');
                $column->tooltip = Az::l('Расположения клиентов');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true,
                        'multiple' => true,
                    ],
                ];
                $column->fkQuery = [
                    'role' => 'client',
                ];

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
        'code',
        'title',
        'tranz',
        'accept',
        'active',
        'date',
        'date_deliver',
        'shipment_type',
        'shop_courier_id',
        'responsible',
        'comment',
        'ware_place_ids',
        'user_place_ids',
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
                                'responsible',
                                'name',
                                'code',
                                'date',
                                'date_deliver',
                                'shipment_type',
                                'shop_courier_id',
                                'comment',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopShipment $model = null)
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
        $event->beforeSave = function (ShopShipment $model) {

            if (!$this->isNewRecord) {
                $shop_orders = ShopOrder::find()
                    ->where([
                        'shop_shipment_id' => $model->id
                    ])
                    ->all();

                foreach ($shop_orders as $shop_order) {
                    $shop_order->date_deliver = $model->date_deliver;
                    $shop_order->configs->rules = [
                        [
                            validatorSafe
                        ]
                    ];
                    $shop_order->save();
                }

                return null;
            }

        };

        /*
        $event->beforeDelete = function (CoreQuestion $model) {
         return null;
        };

        $event->afterDelete = function (CoreQuestion $model) {
         return null;
        };

        $event->beforeSave = function (CoreQuestion $model) {
         return null;
        };

        $event->afterSave = function (CoreQuestion $model) {
         return null;
        };

        $event->beforeValidate = function (CoreQuestion $model) {
         return null;
        };

        $event->afterValidate = function (CoreQuestion $model) {
         return null;
        };

        $event->afterRefresh = function (CoreQuestion $model) {
         return null;
        };

        $event->afterFind = function (CoreQuestion $model) {
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
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many


    /**
     *
     * Function  getShopOrdersWithShopShipmentIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopOrder
     */            
    public function getShopOrdersWithShopShipmentIdMany()
    {
       return $this->getMany(ShopOrder::class, [
            'shop_shipment_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopOrdersWithShopShipmentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopOrdersWithShopShipmentId()
    {
       return $this->hasMany(ShopOrder::class, [
            'shop_shipment_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareAcceptsWithShopShipmentIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareAccept
     */            
    public function getWareAcceptsWithShopShipmentIdMany()
    {
       return $this->getMany(WareAccept::class, [
            'shop_shipment_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareAcceptsWithShopShipmentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareAcceptsWithShopShipmentId()
    {
       return $this->hasMany(WareAccept::class, [
            'shop_shipment_id' => 'id',
        ]);     
    }


    #endregion


}

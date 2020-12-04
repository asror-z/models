<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\calls;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\user\User;
use zetsoft\models\calls\CallsQueue;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CallsOrder
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $shop_order_id
 * @property string $target
 * @property int $user_id
 * @property int $calls_queue_id
 * @property int $retry_count
 * @property int $status
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CallsOrder extends ZActiveRecord
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
    public $shop_order_id;
    public $target;
    public $user_id;
    public $calls_queue_id;
    public $retry_count;
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
        'shop_order_id',
        'target',
        'user_id',
        'calls_queue_id',
        'retry_count',
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

    /* @var array $_target*/
    public $_target;  
    public const target = [
        'queue' => 'queue',
        'agent' => 'agent',
    ];

    /* @var array $_status*/
    public $_status;  
    public const status = [
        'new' => 'new',
        'queue' => 'queue',
        'process' => 'process',
        'finished' => 'finished',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Транспортные средства';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_target = [
            'queue' => Az::l('Очередь'),
            'agent' => Az::l('Оператор'),
        ];
        
        $this->_status = [
            'new' => Az::l('Новый'),
            'queue' => Az::l('В очереди'),
            'process' => Az::l('В процессе'),
            'finished' => Az::l('Закончено'),
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
			'shop_order_id',
			'target',
			'user_id',
			'calls_queue_id',
			'retry_count',
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

            $config->hasOne = [
                    'ShopOrder' => [
                        'shop_order_id' => 'id',
                    ],
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CallsQueue' => [
                        'calls_queue_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Транспортные средства');

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

                $column->index = true;
                $column->title = Az::l('Заказ');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'target' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Цель');
                $column->data = [
                    'queue' => Az::l('Очередь'),
                    'agent' => Az::l('Оператор'),
                ];
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZHRadioButtonGroupWidget::class;

                return $column;
            },
            
           
            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оператор');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'calls_queue_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Очеред операторов');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'retry_count' => function (FormDb $column) {

                $column->title = Az::l('Количество попыток');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->title = Az::l('Статус');
                $column->dbType = dbTypeInteger;
                $column->data = [
                    'new' => Az::l('Новый'),
                    'queue' => Az::l('В очереди'),
                    'process' => Az::l('В процессе'),
                    'finished' => Az::l('Закончено'),
                ];
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

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
        'shop_order_id',
        'target',
        'user_id',
        'calls_queue_id',
        'retry_count',
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
                            ],
                            [
                                'shop_order_id',
                            ],
                            [
                                'target',
                            ],
                            [
                                'user_id',
                            ],
                            [
                                'calls_queue_id',
                            ],
                            [
                                'retry_count',
                            ],
                            [
                                'status',
                            ],
                            [
                                'created_at',
                            ],
                            [
                                'modified_at',
                            ],
                            [
                                'created_by',
                            ],
                            [
                                'modified_by',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
                                public function value(CallsOrder $model = null)
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
        /*
        $event->beforeDelete = function (User $model) {
        return null;
        };

        $event->afterDelete = function (User $model) {
        return null;
        };

        $event->beforeSave = function (User $model) {
        return null;
        };

        $event->afterSave = function (User $model) {
        return null;
        };

        $event->beforeValidate = function (User $model) {
        return null;
        };

        $event->afterValidate = function (User $model) {
        return null;
        };

        $event->afterRefresh = function (User $model) {
        return null;
        };

        $event->afterFind = function (User $model) {
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
     * Function  getUser
     * @return bool|\yii\db\ActiveRecord|User|null
     */            
    public function getUserOne()
    {
        return $this->getOne(User::class, [
          'id' => 'user_id',
      ]);    
    }
    
     /**
     *
     * Function  getUser
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getUser()
    {
        return $this->hasOne(User::class, [
          'id' => 'user_id',
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
     * Function  getCallsQueue
     * @return bool|\yii\db\ActiveRecord|CallsQueue|null
     */            
    public function getCallsQueueOne()
    {
        return $this->getOne(CallsQueue::class, [
          'id' => 'calls_queue_id',
      ]);    
    }
    
     /**
     *
     * Function  getCallsQueue
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCallsQueue()
    {
        return $this->hasOne(CallsQueue::class, [
          'id' => 'calls_queue_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}

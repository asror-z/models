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
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\ware\WareAccept;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopPayment
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
 * @property int $user_id
 * @property int $payment
 * @property string $code
 * @property string $processor
 * @property double $total
 * @property string $date
 * @property string $status
 * @property string $details
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopPayment extends ZActiveRecord
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
    public $user_id;
    public $payment;
    public $code;
    public $processor;
    public $total;
    public $date;
    public $status;
    public $details;
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
        'user_id',
        'payment',
        'code',
        'processor',
        'total',
        'date',
        'status',
        'details',
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
        'ok' => 'ok',
        'fail' => 'fail',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Платежные шлюзы';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'ok' => Az::l('ok'),
            'fail' => Az::l('fail'),
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
			'user_id',
			'payment',
			'code',
			'processor',
			'total',
			'date',
			'status',
			'details',
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
                ];
            $config->title = Az::l('Платежные шлюзы');

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
                $column->tooltip = Az::l('Идентификатор заказа для которого осуществляется платеж');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'user_id' => function (FormDb $column) {

                $column->title = Az::l('Пользователь');
                $column->tooltip = Az::l('Пользователь осуществляемый платеж');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'payment' => function (FormDb $column) {

                $column->title = Az::l('Идентификатор платежа');
                $column->tooltip = Az::l('Идентификатор платежа');
                $column->dbType = dbTypeInteger;

                return $column;
            },
            
           
            'code' => function (FormDb $column) {

                $column->title = Az::l('Код транзакции');
                $column->tooltip = Az::l('Код для транзакции');

                return $column;
            },
            
           
            'processor' => function (FormDb $column) {

                $column->title = Az::l('Процессор');
                $column->tooltip = Az::l('Процессор');

                return $column;
            },
            
           
            'total' => function (FormDb $column) {

                $column->title = Az::l('Всего к оплате');
                $column->tooltip = Az::l('Общая сумма для оплаты');
                $column->dbType = dbTypeDouble;

                return $column;
            },
            
           
            'date' => function (FormDb $column) {

                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                return $column;
            },
            
           
            'status' => function (FormDb $column) {

                $column->title = Az::l('Состояние');
                $column->tooltip = Az::l('Состояние платежа');
                $column->data = [
                    'ok' => Az::l('ok'),
                    'fail' => Az::l('fail'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },
            
           
            'details' => function (FormDb $column) {

                $column->title = Az::l('Детали');
                $column->tooltip = Az::l('Прочие детали');

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
        'user_id',
        'payment',
        'code',
        'processor',
        'total',
        'date',
        'status',
        'details',
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
                                'user_id',
                                'payment',
                                'code',
                                'processor',
                                'total',
                                'date',
                                'status',
                                'details',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
            public function value(ShopPayment $model = null)
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
    $event->beforeDelete = function (CorePayment $model) {
      return null;
    };

    $event->afterDelete = function (CorePayment $model) {
      return null;
    };

    $event->beforeSave = function (CorePayment $model) {
      return null;
    };

    $event->afterSave = function (CorePayment $model) {
      return null;
    };

    $event->beforeValidate = function (CorePayment $model) {
      return null;
    };

    $event->afterValidate = function (CorePayment $model) {
      return null;
    };

    $event->afterRefresh = function (CorePayment $model) {
      return null;
    };

    $event->afterFind = function (CorePayment $model) {
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
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}

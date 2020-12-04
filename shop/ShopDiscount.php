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


use zetsoft\dbdata\eyuf\OperatorData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZTelInputWidget;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\shop\ShopPayment;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopDiscount
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $min_price
 * @property array $type
 * @property array $kind
 * @property int $discount_percent
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopDiscount extends ZActiveRecord
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
    public $min_price;
    public $type;
    public $kind;
    public $discount_percent;
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
        'min_price',
        'type',
        'kind',
        'discount_percent',
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

    /* @var array $_type*/
    public $_type;  
    public const type = [
        'amount' => 'amount',
        'sum' => 'sum',
        'special_days' => 'special_days',
        'special_hours' => 'special_hours',
        'first_order' => 'first_order',
        'special_people' => 'special_people',
    ];

    /* @var array $_kind*/
    public $_kind;  
    public const kind = [
        'percent' => 'percent',
        'sum' => 'sum',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Скидки';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'amount' => Az::l('По количеству покупок'),
            'sum' => Az::l('При покупке на определенную сумму'),
            'special_days' => Az::l('По определенным дням'),
            'special_hours' => Az::l('По определенным часам'),
            'first_order' => Az::l('За первую покупку'),
            'special_people' => Az::l('Для клиентов, входящих в определенный сегмент'),
        ];
        
        $this->_kind = [
            'percent' => Az::l('Процентная скидка'),
            'sum' => Az::l('Скидка на определенную сумму'),
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
			'min_price',
			'type',
			'kind',
			'discount_percent',
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
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->title = Az::l('Скидки');

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
           
            'min_price' => function (FormDb $column) {

                $column->indexUnique = true;
                $column->title = Az::l('Минимальная сумма заказа');
                $column->tooltip = Az::l('Минимальная сумма заказа для использования скидки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

                return $column;
            },

            'type' => function (FormDb $column) {

                $column->title = Az::l('Тип скидки');
                $column->tooltip = Az::l('Возможные типы скидок которые можно предложить клиентам');
                $column->dbType = dbTypeJsonb;
                $column->data = [
                    'amount' => Az::l('По количеству покупок'),
                    'sum' => Az::l('При покупке на определенную сумму'),
                    'special_days' => Az::l('По определенным дням'),
                    'special_hours' => Az::l('По определенным часам'),
                    'first_order' => Az::l('За первую покупку'),
                    'special_people' => Az::l('Для клиентов, входящих в определенный сегмент'),
                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'kind' => function (FormDb $column) {

                $column->title = Az::l('Вид скидки');
                $column->tooltip = Az::l('Возможные виды скидок которые можно предложить клиентам');
                $column->dbType = dbTypeJsonb;
                $column->data = [
                    'percent' => Az::l('Процентная скидка'),
                    'sum' => Az::l('Скидка на определенную сумму'),

                ];
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'discount_percent' => function (FormDb $column) {

                $column->title = Az::l('Процент скидки');
                $column->tooltip = Az::l('Процент скидки');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;

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
        'min_price',
        'type',
        'kind',
        'discount_percent',
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
                                'min_price',
                                'discount_percent',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
            public function value(ShopDiscount $model = null)
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

     $event->beforeSave = function (ShopOrder $model) {
         if (!$this->isNewRecord){
           /* if ($model->oldAttributes['operator_id'] == null and $model->operator_id != null){
                $model->status = $this->_status['checking'];
            }
            /** For add status history on change status */
             /*if ($model->oldAttributes['status'] != $model->status){
                 $time = date('Y-m-d h:i:s');
                 $new_status = $model->status;
                 $old_status = $model->oldAttributes['status'];
                 $user_id = $this->userIdentity()->id;

                 $new_json = [
                    'time' => $time,
                    'new_status' => $new_status,
                    'old_status' => $old_status,
                    'user_id' => $user_id,
                 ];

                 $status = $model->oldAttributes['status_history'];
                 $status[] = $new_json;

                 $model->status_history = $status;
             } */
         }
     };


 /*
 $event->beforeDelete = function (UserCompany $model) {
 return null;
 };

 $event->afterDelete = function (UserCompany $model) {
 return null;
 };

 $event->beforeSave = function (UserCompany $model) {
 return null;
 };

 $event->afterSave = function (UserCompany $model) {
 return null;
 };

 $event->beforeValidate = function (UserCompany $model) {
 return null;
 };

 $event->afterValidate = function (UserCompany $model) {
 return null;
 };

 $event->afterRefresh = function (UserCompany $model) {
 return null;
 };

 $event->afterFind = function (UserCompany $model) {
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

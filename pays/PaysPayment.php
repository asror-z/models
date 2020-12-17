<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\pays;


use Closure;
use Underscore\Types\Number;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use zetsoft\dbdata\core\SettingData;
use zetsoft\dbdata\data\DbData;
use zetsoft\dbdata\user\UserPaymentData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\calls\CallsOrder;
use zetsoft\models\calls\CallsRecord;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\shop\ShopOrderItem;
use zetsoft\models\user\User;
use zetsoft\models\user\UserCompany;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\audios\ZAudioWidget;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKSelect2WidgetRav;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\values\ZFormViewWidget;
use zetsoft\models\ware\Ware;
use zetsoft\models\calls\CallsCdr;
use zetsoft\models\calls\CallsCel;
use zetsoft\models\ware\WareReturn;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\cpas\CpasStream;
use zetsoft\models\shop\ShopRejectCause;
use zetsoft\models\shop\ShopDelay;
use zetsoft\models\shop\ShopDelayCause;
use zetsoft\models\shop\ShopPackaging;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopChannel;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\shop\ShopPayment;
use zetsoft\widgets\former\ZMultiWidget;
use zetsoft\widgets\values\ZMultiViewWidget;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\pays\PaysIncome;
use zetsoft\models\pays\PaysWithdraw;
use zetsoft\models\cpas\CpasPaysHistory;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PaysPayment
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $user_id
 * @property string $form
 * @property array $value
 * @property boolean $confirm
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PaysPayment extends ZActiveRecord
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
    public $user_id;
    public $form;
    public $value;
    public $confirm;
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
        'user_id',
        'form',
        'value',
        'confirm',
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
    public static ?string $title = Azl . 'Платежная система';
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
			'user_id',
			'form',
			'value',
			'confirm',
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
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'PaysIncome' => [
                        'pays_payment_id' => 'id',
                    ],
                    'PaysWithdraw' => [
                        'pays_payment_id' => 'id',
                    ],
                    'CpasPaysHistory' => [
                        'pays_payment_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Платежная система');

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



            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Клиент');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->auto = true;
                return $column;
            },


            'form' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Payment');
                $column->data = UserPaymentData::class;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => true
                    ]
                ];
                $column->ajax = false;

                return $column;
            },

            'value' => function (FormDb $column) {

                $column->title = Az::l('Данные');
                $column->dbType = dbTypeJsonb;
                $column->widget = ZFormWidget::class;
                $column->valueWidget = ZFormViewWidget::class;
                $column->options = [
                    'config' => [
                        'formAttr' => 'form',
                    ],
                ];
                $column->valueOptions = [
                    'config' => [
                        'formAttr' => 'form',
                    ],
                ];
                $column->event = function (PaysPayment $model){
                    Az::$app->cpas->cpa->setPaymentName($model);
                };

                $column->mergeHeader = true;

                return $column;
            },


            'confirm' => function (FormDb $column) {

                $column->title = Az::l('Подтвержден');
                $column->tooltip = Az::l('Подтвержден');
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
        'title',
        'tranz',
        'accept',
        'active',
        'user_id',
        'form',
        'value',
        'confirm',
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
                                'user_id',
                                'form',
                                'value',
                                'confirm',
                                'active',
                                'deleted_at',
                                'deleted_by',
                                'deleted_text',
                                'created_at',
                                'modified_at',
                                'created_by',
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
    public function value(ShopOrder &$model = null)
    {
        if ($model === null)
            $model = $this;

        $shopOrderItems = ShopOrderItem::findAll(['shop_order_id' => $model->id]);
        if (!$this->emptyOrNullable($shopOrderItems) && !$this->emptyOrNullable($model)) {
            if ($model->user_company_ids === null)
                $model->user_company_ids = [];
            if ($model->ware_ids === null)
                $model->ware_ids = [];


            $collectedItems = collect($shopOrderItems);
            if (empty($model->user_company_ids) || !is_array($model->user_company_ids))
                $model->user_company_ids = [];

            $user_company_ids = ZArrayHelper::merge($model->user_company_ids, ZArrayHelper::getColumn($shopOrderItems, 'user_company_id'));

            $model->user_company_ids = array_unique($user_company_ids);
            if (empty($model->ware_ids) || !is_array($model->ware_ids))
                $model->ware_ids = [];
            $ware_ids = ZArrayHelper::merge($model->ware_ids, ZArrayHelper::getColumn($shopOrderItems, 'ware_id'));

            $model->user_company_ids = array_unique($ware_ids);

            $model->price = $collectedItems->sum('price_all');
        }

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

        /*$event->beforeSave = function (ShopOrder $model) {

            // $this->value($model);

            if (ZArrayHelper::keyExists($model->status_accept, self::status_logistics))
                $model->status_logistics = $model->status_accept;

            $model->total_price = Az::$app->menu->orderNorms->setTotalPrice($model);

            if ($this->isNewRecord) {
                $model->status_client = ShopOrder::status_client['accepted'];
                $model->status_logistics = ShopOrder::status_logistics['new'];
                $model->status_callcenter = ShopOrder::status_callcenter['new'];
            } else {
                if ($this->emptyOrNullable($model->shop_shipment_id)) {

                    $shopShipment = ShopShipment::findOne($model->shop_shipment_id);
                    if ($shopShipment !== null) {

                    }
                }
            }

        };*/

//             if (!$this->isNewRecord) {
//                 if ($model->oldAttributes['operator_id'] == null and $model->operator_id != null) {
//                     $model->status = $this->_status['checking'];
//                 }
//                 // For add status history on change status
//                 if ($model->oldAttributes['status'] != $model->status) {
//                     $time = date('Y-m-d h:i:s');
//                     $new_status = $model->status;
//                     $old_status = $model->oldAttributes['status'];
//                     $user_id = $this->userIdentity()->id;
//
//                     $new_json = [
//                         'time' => $time,
//                         'new_status' => $new_status,
//                         'old_status' => $old_status,
//                         'user_id' => $user_id,
//                     ];
//
//                     $status = $model->oldAttributes['status_history'];
//                     $status[] = $new_json;
//
//                     $model->status_history = $status;
//                 }
//             }

        /*    $event->beforeSave = function (ShopOrder $model) {
                if (!$this->isNewRecord) {

                    switch ($model->status_logistics) {

                        case ShopOrder::status_logistics['buyed']:
                            Az::$app->market->order->orderBuyed($model);
                            break;

                    }

                }
            };*/


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
          */
        /*
        $event->afterSave = function (ShopOrder $model) {

            $del_price = Az::$app->maps->distance->deliverPrice($model->id, $model->user_company_id);

            $model->deliver_price = $del_price;

            $model->save();

        };
        */
        /*
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


    /**
     *
     * Function  getPaysIncomesWithPaysPaymentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysIncome
     */            
    public function getPaysIncomesWithPaysPaymentIdMany()
    {
       return $this->getMany(PaysIncome::class, [
            'pays_payment_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysIncomesWithPaysPaymentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysIncomesWithPaysPaymentId()
    {
       return $this->hasMany(PaysIncome::class, [
            'pays_payment_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysWithdrawsWithPaysPaymentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysWithdraw
     */            
    public function getPaysWithdrawsWithPaysPaymentIdMany()
    {
       return $this->getMany(PaysWithdraw::class, [
            'pays_payment_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysWithdrawsWithPaysPaymentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysWithdrawsWithPaysPaymentId()
    {
       return $this->hasMany(PaysWithdraw::class, [
            'pays_payment_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getCpasPaysHistoriesWithPaysPaymentIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasPaysHistory
     */            
    public function getCpasPaysHistoriesWithPaysPaymentIdMany()
    {
       return $this->getMany(CpasPaysHistory::class, [
            'pays_payment_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasPaysHistoriesWithPaysPaymentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasPaysHistoriesWithPaysPaymentId()
    {
       return $this->hasMany(CpasPaysHistory::class, [
            'pays_payment_id' => 'id',
        ]);     
    }


    #endregion


}

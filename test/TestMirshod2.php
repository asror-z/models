<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\test;


use kartik\grid\DataColumn;
use Underscore\Types\Number;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\calls\CallsCdr;
use zetsoft\models\calls\CallsCel;
use zetsoft\models\calls\CallsOrder;
use zetsoft\models\calls\CallsRecord;
use zetsoft\models\calls\CallsUserman;
use zetsoft\models\cpas\CpasTracker;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\shop\ShopShipment;
use zetsoft\models\user\User;
use zetsoft\models\user\UserCompany;
use zetsoft\models\ware\Ware;
use zetsoft\models\ware\WareAccept;
use zetsoft\models\ware\WareReturn;
use zetsoft\service\cores\Date;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\column\ZKDataColumn;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\audios\ZAudioWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKDateTimePickerWidget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZKTouchSpinWidget;
use zetsoft\models\shop\ShopRejectCause;
use zetsoft\models\shop\ShopDelay;
use zetsoft\models\shop\ShopDelayCause;
use zetsoft\models\shop\ShopPackaging;
use zetsoft\models\shop\ShopCoupon;
use zetsoft\models\shop\ShopChannel;
use zetsoft\models\shop\ShopElement;
use zetsoft\models\shop\ShopPayment;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZPeriodPickerWidget;
use zetsoft\widgets\navigat\ZButtonWidget;
use zetsoft\widgets\values\ZDateFormatWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    TestMirshod2
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
 * @property string $number
 * @property string $email
 * @property string $username
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class TestMirshod2 extends ZActiveRecord
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
    public $number;
    public $email;
    public $username;
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
        'number',
        'email',
        'username',
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
    public static ?string $title = Azl . 'Заказы';
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
			'code',
			'title',
			'tranz',
			'accept',
			'active',
			'number',
			'email',
			'username',
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

            $config->addCode = true;
            $config->nameValue = 'Заказ клиента №{number} от {created_at}. Ф.И.О {contact_name}';

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $config->codeValue = function (TestMirshod2 $model) {
                return Number::paddingLeft($model->number, 12);
            };

            $config->title = Az::l('Заказы');

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

            'number' => function (FormDb $column) {

                $column->title = Az::l('Номер заказа');
                $column->readonly = true;
                $column->width = '100px';

                return $column;
            },
            'email' => function (FormDb $column) {

                $column->title = Az::l('email клиента');
                $column->width = '100px';
                $column->rules = [
                    [
                        validatorEmail
                    ],
                ];

                return $column;
            },
            'username' => function (FormDb $column) {

                $column->title = Az::l('Najim');

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
        'number',
        'email',
        'username',
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
                                'code',
                            ],
                            [
                                'date',
                                'responsible',
                            ],
                            [
                                'user_id',
                                'contact_name',
                            ],
                            [
                                'contact_phone',
                                'add_contact_phone',
                                'called_time',
                            ],
                            [
                                'comment_user',
                                'place_adress_id',
                            ],
                            [
                                'distance',
                                'user_company_ids',
                            ],
                            [
                                'ware_ids',
                                'operator',
                            ],
                            [
                                'comment_agent',
                                'tasks',
                            ],
                            [
                                'source',
                                'shop_reject_cause_id',
                            ],
                            [
                                'status_client',
                                'status_callcenter',
                            ],
                            [
                                'status_accept',
                                'date_deliver',
                            ],
                            [
                                'date_approve',
                                'date_return',
                            ],
                            [
                                'delayed_deliver_date',
                                'weight_plan',
                            ],
                            [
                                'shop_delay_id',
                                'shop_delay_cause_id',
                            ],
                            [
                                'packaging',
                                'labelled',
                            ],
                            [
                                'fragile',
                                'weight',
                            ],
                            [
                                'volume',
                                'shop_shipment_id',
                            ],
                            [
                                'price',
                                'deliver_price',
                            ],
                            [
                                'total_price',
                                'shop_coupon_id',
                            ],
                            [
                                'shop_channel_id',
                                'payment_type',
                            ],
                            [
                                'additional_payment_type',
                                'additional_received_money',
                            ],
                            [
                                'additional_deliver',
                                'prepayment',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(TestMirshod2 &$model = null)
    {
        if ($model === null) {
            $model = $this;
        }

        $TestMirshod2Items = TestMirshod2Item::find()
            ->where([
                'shop_order_id' => $model->id
            ])
            ->all();

        /*$TestMirshod2Item = new TestMirshod2Item();

        $shopCatalog = ShopCatalog::find()->where(['id' => $TestMirshod2Item->shop_catalog_id])->all();*/


        if (!$this->emptyOrNullable($TestMirshod2Items) && !$this->emptyOrNullable($model)) {
            if ($model->user_company_ids === null)
                $model->user_company_ids = [];

            if ($model->ware_ids === null)
                $model->ware_ids = [];

            $collectedItems = collect($TestMirshod2Items);
            if (empty($model->user_company_ids) || !is_array($model->user_company_ids))
                $model->user_company_ids = [];

            $user_company_ids = ZArrayHelper::merge($model->user_company_ids, ZArrayHelper::getColumn($TestMirshod2Items, 'user_company_id'));

            $model->shop_element_ids = ZArrayHelper::getColumn($TestMirshod2Items, 'id');

            $model->user_company_ids = array_unique($user_company_ids);
            if (empty($model->ware_ids) || !is_array($model->ware_ids))
                $model->ware_ids = [];
            $ware_ids = ZArrayHelper::merge($model->ware_ids, ZArrayHelper::getColumn($TestMirshod2Items, 'ware_id'));

            $model->user_company_ids = array_unique($ware_ids);

        }

        $model->configs->rules = [[validatorSafe]];

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


        /*$event->beforeDelete = function (TestMirshod2Item $model) {

            TestMirshod2Item::deleteAll([
                'shop_order_id' => $model->id
            ]);

        };*/

        /*$event->beforeSave = function (TestMirshod2 $model) {

            // $this->value($model);

            if (ZArrayHelper::keyExists($model->status_accept, self::status_logistics))
                $model->status_logistics = $model->status_accept;

            $model->total_price = Az::$app->menu->orderNorms->setTotalPrice($model);

            if ($this->isNewRecord) {
                $model->status_client = TestMirshod2::status_client['accepted'];
                $model->status_logistics = TestMirshod2::status_logistics['new'];
                $model->status_callcenter = TestMirshod2::status_callcenter['new'];
            } else {
                if ($this->emptyOrNullable($model->shop_shipment_id)) {

                    $shopShipment = ShopShipment::findOne($model->shop_shipment_id);
                    if ($shopShipment !== null) {

                    }
                }
            }

        };*/

        /* if (!$this->isNewRecord) {
             if ($model->oldAttributes['operator_id'] == null and $model->operator_id != null) {
                 $model->status = $this->_status['checking'];
             }
             // For add status history on change status
             if ($model->oldAttributes['status'] != $model->status) {
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
             }
         }*/

        /*    $event->beforeSave = function (TestMirshod2 $model) {
                if (!$this->isNewRecord) {

                    switch ($model->status_logistics) {

                        case TestMirshod2::status_logistics['buyed']:
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
        $event->afterSave = function (TestMirshod2 $model) {

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



    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}

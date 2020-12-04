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


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\models\place\PlaceCountry;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\user\User;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\ware\Ware;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\place\PlaceRegion;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PaysSysPaysys
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $place_region_id
 * @property int $parent_id
 * @property int $vendor_id
 * @property int $payment_id
 * @property string $payment_name
 * @property int $agr_trans_id
 * @property int $merchant_trans_id
 * @property int $merchant_trans_amount
 * @property string $environment
 * @property int $sign_time
 * @property string $sign_string
 * @property string $merchant_trans_data
 * @property int $ware_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PaysSysPaysys extends ZActiveRecord
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
    public $place_region_id;
    public $parent_id;
    public $vendor_id;
    public $payment_id;
    public $payment_name;
    public $agr_trans_id;
    public $merchant_trans_id;
    public $merchant_trans_amount;
    public $environment;
    public $sign_time;
    public $sign_string;
    public $merchant_trans_data;
    public $ware_id;
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
        'place_region_id',
        'parent_id',
        'vendor_id',
        'payment_id',
        'payment_name',
        'agr_trans_id',
        'merchant_trans_id',
        'merchant_trans_amount',
        'environment',
        'sign_time',
        'sign_string',
        'merchant_trans_data',
        'ware_id',
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
    public static ?string $title = Azl . 'Система Paysys';
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
			'place_region_id',
			'parent_id',
			'vendor_id',
			'payment_id',
			'payment_name',
			'agr_trans_id',
			'merchant_trans_id',
			'merchant_trans_amount',
			'environment',
			'sign_time',
			'sign_string',
			'merchant_trans_data',
			'ware_id',
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
                    'PlaceRegion' => [
                        'place_region_id' => 'id',
                        'parent_id' => 'id',
                    ],
                    'Vendor' => [
                        'vendor_id' => 'id',
                    ],
                    'Payment' => [
                        'payment_id' => 'id',
                    ],
                    'AgrTrans' => [
                        'agr_trans_id' => 'id',
                    ],
                    'MerchantTrans' => [
                        'merchant_trans_id' => 'id',
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
            $config->title = Az::l('Система Paysys');

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

            'place_region_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Страна');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'parent_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящий');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'depend' => 'place_country_id',
                        'url' => '/core/region/getRegion.aspx',
                        'params' => [
                            'dependAttr' => 'shop_category_id',
                        ],
                    ],
                ];
                $column->fkTable = 'place_region';

                return $column;
            },


            'vendor_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Продавец');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'payment_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оплата_id');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'payment_name' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оплата_имя');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'agr_trans_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Соглашение');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'merchant_trans_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Торговец_id');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'merchant_trans_amount' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Торговец_количество');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'environment' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Окружающая среда');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'sign_time' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Подписка время');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'sign_string' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Подписка строка');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'merchant_trans_data' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Торговец данные');
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'ware_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Обслуживаемый склад');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;

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
        'place_region_id',
        'parent_id',
        'vendor_id',
        'payment_id',
        'payment_name',
        'agr_trans_id',
        'merchant_trans_id',
        'merchant_trans_amount',
        'environment',
        'sign_time',
        'sign_string',
        'merchant_trans_data',
        'ware_id',
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
                                'place_region_id',
                            ],
                            [
                                'parent_id',
                            ],
                            [
                                'ware_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(PlaceCity $model = null)
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

//        $event->beforeSave = function (CoreRegion $model) {
//            Az::$app->market->address->generateRegionName($model);
//        };
        /*
        $event->beforeDelete = function (CoreRegion $model) {
        return null;
        };

        $event->afterDelete = function (CoreRegion $model) {
        return null;
        };

        $event->beforeSave = function (CoreRegion $model) {
        return null;
        };

        $event->afterSave = function (CoreRegion $model) {
        return null;
        };

        $event->beforeValidate = function (CoreRegion $model) {
        return null;
        };

        $event->afterValidate = function (CoreRegion $model) {
        return null;
        };

        $event->afterRefresh = function (CoreRegion $model) {
        return null;
        };

        $event->afterFind = function (CoreRegion $model) {
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
     * Function  getPlaceRegion
     * @return bool|\yii\db\ActiveRecord|PlaceRegion|null
     */            
    public function getPlaceRegionOne()
    {
        return $this->getOne(PlaceRegion::class, [
          'id' => 'place_region_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceRegion
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceRegion()
    {
        return $this->hasOne(PlaceRegion::class, [
          'id' => 'place_region_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getParent
     * @return bool|\yii\db\ActiveRecord|PlaceRegion|null
     */            
    public function getParentOne()
    {
        return $this->getOne(PlaceRegion::class, [
          'id' => 'parent_id',
      ]);    
    }
    
     /**
     *
     * Function  getParent
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getParent()
    {
        return $this->hasOne(PlaceRegion::class, [
          'id' => 'parent_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getVendor
     * @return bool|\yii\db\ActiveRecord|Vendor|null
     */            
    public function getVendorOne()
    {
        return $this->getOne(Vendor::class, [
          'id' => 'vendor_id',
      ]);    
    }
    
     /**
     *
     * Function  getVendor
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getVendor()
    {
        return $this->hasOne(Vendor::class, [
          'id' => 'vendor_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getPayment
     * @return bool|\yii\db\ActiveRecord|Payment|null
     */            
    public function getPaymentOne()
    {
        return $this->getOne(Payment::class, [
          'id' => 'payment_id',
      ]);    
    }
    
     /**
     *
     * Function  getPayment
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPayment()
    {
        return $this->hasOne(Payment::class, [
          'id' => 'payment_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getAgrTrans
     * @return bool|\yii\db\ActiveRecord|AgrTrans|null
     */            
    public function getAgrTransOne()
    {
        return $this->getOne(AgrTrans::class, [
          'id' => 'agr_trans_id',
      ]);    
    }
    
     /**
     *
     * Function  getAgrTrans
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getAgrTrans()
    {
        return $this->hasOne(AgrTrans::class, [
          'id' => 'agr_trans_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getMerchantTrans
     * @return bool|\yii\db\ActiveRecord|MerchantTrans|null
     */            
    public function getMerchantTransOne()
    {
        return $this->getOne(MerchantTrans::class, [
          'id' => 'merchant_trans_id',
      ]);    
    }
    
     /**
     *
     * Function  getMerchantTrans
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getMerchantTrans()
    {
        return $this->hasOne(MerchantTrans::class, [
          'id' => 'merchant_trans_id',
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



    #endregion


}

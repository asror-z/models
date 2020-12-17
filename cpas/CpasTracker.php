<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\cpas;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\former\lang\LanguageForm;
use zetsoft\former\eyuf\EyufNeedForm;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZFileInputWidget;
use zetsoft\widgets\inputes\ZHRadioButtonGroupWidget;
use zetsoft\widgets\inputes\ZInputMaskWidget;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\inputes\ZIconPickerWidget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\models\menu\Menu;
use zetsoft\dbitem\data\Event;
use zetsoft\models\shop\ShopProduct;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\core\CoreQueue;
use zetsoft\models\shop\ShopCategory;
use zetsoft\models\shop\ShopOption;
use zetsoft\models\shop\ShopReview;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\shop\ShopQuestion;
use zetsoft\models\shop\ShopOverview;
use zetsoft\models\user\User;
use zetsoft\models\shop\ShopOrder;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\cpas\CpasTeaser;
use zetsoft\models\cpas\CpasStreamItem;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\cpas\CpasCompany;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasTracker
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $cpas_stream_item_id
 * @property int $cpas_offer_id
 * @property int $user_id
 * @property string $contact_name
 * @property int $cpas_company_id
 * @property string $contact_phone
 * @property int $amount
 * @property int $shop_order_id
 * @property string $status
 * @property string $referrer
 * @property string $country
 * @property string $city
 * @property string $region
 * @property string $timezone
 * @property string $utc
 * @property string $lat
 * @property string $lon
 * @property string $ip
 * @property string $device_model
 * @property string $device_os
 * @property string $browser
 * @property string $revenue
 * @property string $keyword
 * @property string $cost
 * @property string $currency
 * @property int $external_id
 * @property int $creative_id
 * @property int $ad_campaign_id
 * @property string $sub_id_1
 * @property string $sub_id_2
 * @property string $sub_id_3
 * @property string $sub_id_4
 * @property string $sub_id_5
 * @property string $sub_id_6
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasTracker extends ZActiveRecord
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
    public $cpas_stream_item_id;
    public $cpas_offer_id;
    public $user_id;
    public $contact_name;
    public $cpas_company_id;
    public $contact_phone;
    public $amount;
    public $shop_order_id;
    public $status;
    public $referrer;
    public $country;
    public $city;
    public $region;
    public $timezone;
    public $utc;
    public $lat;
    public $lon;
    public $ip;
    public $device_model;
    public $device_os;
    public $browser;
    public $revenue;
    public $keyword;
    public $cost;
    public $currency;
    public $external_id;
    public $creative_id;
    public $ad_campaign_id;
    public $sub_id_1;
    public $sub_id_2;
    public $sub_id_3;
    public $sub_id_4;
    public $sub_id_5;
    public $sub_id_6;
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
        'cpas_stream_item_id',
        'cpas_offer_id',
        'user_id',
        'contact_name',
        'cpas_company_id',
        'contact_phone',
        'amount',
        'shop_order_id',
        'status',
        'referrer',
        'country',
        'city',
        'region',
        'timezone',
        'utc',
        'lat',
        'lon',
        'ip',
        'device_model',
        'device_os',
        'browser',
        'revenue',
        'keyword',
        'cost',
        'currency',
        'external_id',
        'creative_id',
        'ad_campaign_id',
        'sub_id_1',
        'sub_id_2',
        'sub_id_3',
        'sub_id_4',
        'sub_id_5',
        'sub_id_6',
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
        'trash' => 'trash',
        'cancel' => 'cancel',
        'accept' => 'accept',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Бренды';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'new' => Az::l('Новый'),
            'trash' => Az::l('Трэш'),
            'cancel' => Az::l('Отменен'),
            'accept' => Az::l('Одобрен'),
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
			'cpas_stream_item_id',
			'cpas_offer_id',
			'user_id',
			'contact_name',
			'cpas_company_id',
			'contact_phone',
			'amount',
			'shop_order_id',
			'status',
			'referrer',
			'country',
			'city',
			'region',
			'timezone',
			'utc',
			'lat',
			'lon',
			'ip',
			'device_model',
			'device_os',
			'browser',
			'revenue',
			'keyword',
			'cost',
			'currency',
			'external_id',
			'creative_id',
			'ad_campaign_id',
			'sub_id_1',
			'sub_id_2',
			'sub_id_3',
			'sub_id_4',
			'sub_id_5',
			'sub_id_6',
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
                    'CpasStreamItem' => [
                        'cpas_stream_item_id' => 'id',
                    ],
                    'CpasOffer' => [
                        'cpas_offer_id' => 'id',
                    ],
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'CpasCompany' => [
                        'cpas_company_id' => 'id',
                    ],
                    'ShopOrder' => [
                        'shop_order_id' => 'id',
                    ],
                    'External' => [
                        'external_id' => 'id',
                    ],
                    'Creative' => [
                        'creative_id' => 'id',
                    ],
                    'AdCampaign' => [
                        'ad_campaign_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Бренды');

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

            'cpas_stream_item_id' => static function (FormDb $column) {

                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Элемент потока');
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => false
                    ]
                ];
                $column->fkAttr = 'title';
                return $column;
            },

            'cpas_offer_id' => static function (FormDb $column) {
                $column->index = true;
                $column->title = Az::l('Офферы');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkAttr = 'title';
                return $column;
            },

            'user_id' => static function (FormDb $column) {

                $column->index = true;
                $column->dbType = dbTypeInteger;
                $column->title = Az::l('Пользователь');
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => false
                    ]
                ];
                $column->fkAttr = 'email';
                return $column;
            },


            /**
             * User Data
             */

            'contact_name' => static function (FormDb $column) {

                $column->title = Az::l('Контактное имя');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];

                return $column;
            },

            'cpas_company_id' => static function (FormDb $column) {

                $column->title = Az::l('Компания');

                return $column;
            },

            'contact_phone' => static function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Контактный номер');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                //$column->widget = ZInputMaskWidget::class;

                return $column;
            },


            'amount' => static function (FormDb $column) {

                $column->title = Az::l('Количество');
                $column->dbType = dbTypeInteger;

                return $column;
            },


            /**
             *
             * Order Relation
             */

            'shop_order_id' => static function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Заказ');
                $column->widget = ZInputWidget::class;

                return $column;
            },

            'status' => static function (FormDb $column) {

                $column->title = Az::l('Статус');
                $column->data = [
                    'new' => Az::l('Новый'),
                    'trash' => Az::l('Трэш'),
                    'cancel' => Az::l('Отменен'),
                    'accept' => Az::l('Одобрен'),
                ];
                /*$column->event = function (CpasTracker $model) {
                    Az::$app->cpas->cpa->setBalance($model);
                };*/
                $column->widget = ZKSelect2Widget::class;
                $column->options = [
                    'config' => [
                        'ajax' => false
                    ]
                ];


                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            /**
             *
             *
             * Tracker
             */

            'referrer' => static function (FormDb $column) {

                $column->title = Az::l('От куда (Referrer)');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'country' => static function (FormDb $column) {

                $column->title = Az::l('Страна');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'city' => static function (FormDb $column) {

                $column->title = Az::l('Город');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'region' => static function (FormDb $column) {

                $column->title = Az::l('Регион');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'timezone' => static function (FormDb $column) {

                $column->title = Az::l('Часовой пояс');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'utc' => static function (FormDb $column) {

                $column->title = Az::l('UTC');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'lat' => static function (FormDb $column) {

                $column->title = Az::l('Широта');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'lon' => static function (FormDb $column) {

                $column->title = Az::l('Долгота');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'ip' => static function (FormDb $column) {

                $column->title = Az::l('IP адресс');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'device_model' => static function (FormDb $column) {

                $column->title = Az::l('Модель телефона');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'device_os' => static function (FormDb $column) {

                $column->title = Az::l('ОС');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            'browser' => static function (FormDb $column) {

                $column->title = Az::l('Браузер');
                $column->widget = ZInputWidget::class;

                return $column;
            },


            /**
             *
             * Moneys
             */

            'revenue' => static function (FormDb $column) {

                $column->title = Az::l('Доход');
                $column->readonly = true;
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->widget = ZInputWidget::class;

                return $column;
            },


            /**
             *
             * Teaser
             */

            'keyword' => static function (FormDb $column) {
                $column->title = Az::l('Ключевик');
                return $column;
            },


            'cost' => static function (FormDb $column) {
                $column->title = Az::l('Расход');
                return $column;
            },


            'currency' => static function (FormDb $column) {
                $column->title = Az::l('Валюта');
                return $column;
            },


            'external_id' => static function (FormDb $column) {
                $column->title = Az::l('External ID');
                return $column;
            },


            'creative_id' => static function (FormDb $column) {
                $column->title = Az::l('Creative ID');
                return $column;
            },
            'ad_campaign_id' => static function (FormDb $column) {
                $column->title = Az::l('Ad campaign ID');
                return $column;
            },

            'sub_id_1' => static function (FormDb $column) {
                $column->title = Az::l('Sub ID 1');
                return $column;
            },
            'sub_id_2' => static function (FormDb $column) {
                $column->title = Az::l('Sub ID 2');
                return $column;
            },
            'sub_id_3' => static function (FormDb $column) {
                $column->title = Az::l('Sub ID 3');
                return $column;
            },
            'sub_id_4' => static function (FormDb $column) {
                $column->title = Az::l('Sub ID 4');
                return $column;
            },
            'sub_id_5' => static function (FormDb $column) {
                $column->title = Az::l('Sub ID 5');
                return $column;
            },
            'sub_id_6' => static function (FormDb $column) {
                $column->title = Az::l('Sub ID 6');
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
        'cpas_stream_item_id',
        'cpas_offer_id',
        'user_id',
        'contact_name',
        'cpas_company_id',
        'contact_phone',
        'amount',
        'shop_order_id',
        'status',
        'referrer',
        'country',
        'city',
        'region',
        'timezone',
        'utc',
        'lat',
        'lon',
        'ip',
        'device_model',
        'device_os',
        'browser',
        'revenue',
        'keyword',
        'cost',
        'currency',
        'external_id',
        'creative_id',
        'ad_campaign_id',
        'sub_id_1',
        'sub_id_2',
        'sub_id_3',
        'sub_id_4',
        'sub_id_5',
        'sub_id_6',
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
                                'tizer_tracker_id',
                                'shop_order_id',
                                'country',
                                'city',
                                'region',
                                'timezone',
                                'utc',
                                'lat',
                                'lon',
                                'ip',
                                'device_model',
                                'device_os',
                                'browser',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(CpasTracker &$model = null)
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

        $event->beforeSave = function (CpasTracker $model) {
            //vdd('sasasaas');

            //start|JakhongirKudratov|2020-10-12

            Az::$app->cpas->cpa->setBalance($model);

            //end|JakhongirKudratov|2020-10-12
        };


        /*
        $event->beforeDelete = function (ShopBrand $model) {
        return null;
        };

        $event->afterDelete = function (ShopBrand $model) {
        return null;
        };

        $event->beforeSave = function (ShopBrand $model) {
        return null;
        };

        $event->afterSave = function (ShopBrand $model) {
        return null;
        };

        $event->beforeValidate = function (ShopBrand $model) {
        return null;
        };

        $event->afterValidate = function (ShopBrand $model) {
        return null;
        };

        $event->afterRefresh = function (ShopBrand $model) {
        return null;
        };

        $event->afterFind = function (ShopBrand $model) {
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
     * Function  getCpasStreamItem
     * @return bool|\yii\db\ActiveRecord|CpasStreamItem|null
     */            
    public function getCpasStreamItemOne()
    {
        return $this->getOne(CpasStreamItem::class, [
          'id' => 'cpas_stream_item_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasStreamItem
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasStreamItem()
    {
        return $this->hasOne(CpasStreamItem::class, [
          'id' => 'cpas_stream_item_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getCpasOffer
     * @return bool|\yii\db\ActiveRecord|CpasOffer|null
     */            
    public function getCpasOfferOne()
    {
        return $this->getOne(CpasOffer::class, [
          'id' => 'cpas_offer_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasOffer
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasOffer()
    {
        return $this->hasOne(CpasOffer::class, [
          'id' => 'cpas_offer_id',
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
     * Function  getCpasCompany
     * @return bool|\yii\db\ActiveRecord|CpasCompany|null
     */            
    public function getCpasCompanyOne()
    {
        return $this->getOne(CpasCompany::class, [
          'id' => 'cpas_company_id',
      ]);    
    }
    
     /**
     *
     * Function  getCpasCompany
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCpasCompany()
    {
        return $this->hasOne(CpasCompany::class, [
          'id' => 'cpas_company_id',
      ]);    
    }
    
    

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
     * Function  getExternal
     * @return bool|\yii\db\ActiveRecord|External|null
     */            
    public function getExternalOne()
    {
        return $this->getOne(External::class, [
          'id' => 'external_id',
      ]);    
    }
    
     /**
     *
     * Function  getExternal
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getExternal()
    {
        return $this->hasOne(External::class, [
          'id' => 'external_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getCreative
     * @return bool|\yii\db\ActiveRecord|Creative|null
     */            
    public function getCreativeOne()
    {
        return $this->getOne(Creative::class, [
          'id' => 'creative_id',
      ]);    
    }
    
     /**
     *
     * Function  getCreative
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getCreative()
    {
        return $this->hasOne(Creative::class, [
          'id' => 'creative_id',
      ]);    
    }
    
    

    /**
     *
     * Function  getAdCampaign
     * @return bool|\yii\db\ActiveRecord|AdCampaign|null
     */            
    public function getAdCampaignOne()
    {
        return $this->getOne(AdCampaign::class, [
          'id' => 'ad_campaign_id',
      ]);    
    }
    
     /**
     *
     * Function  getAdCampaign
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getAdCampaign()
    {
        return $this->hasOne(AdCampaign::class, [
          'id' => 'ad_campaign_id',
      ]);    
    }
    
    


    #endregion

    #region Multi



    #endregion
    
    #region Many



    #endregion


}

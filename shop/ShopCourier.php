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


use zetsoft\dbitem\data\ALLApp;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\Form;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\auto\Auto;
use zetsoft\models\place\PlaceLocation;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\user\User;
use zetsoft\models\user\UserCompany;
use zetsoft\models\ware\WareAccept;
use zetsoft\models\ware\WareExit;
use zetsoft\models\ware\WareReturn;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\former\ZFormWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZKStarRatingWidget;
use zetsoft\models\shop\ShopShipment;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    ShopCourier
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $code
 * @property string $guid
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $delivery_price
 * @property double $award_order
 * @property double $award_return
 * @property double $award_exchange
 * @property double $bonus
 * @property int $deposit
 * @property string $status
 * @property int $rating
 * @property array $place_region_ids
 * @property array $region_form
 * @property int $user_company_id
 * @property int $user_id
 * @property int $auto_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class ShopCourier extends ZActiveRecord
{
    #region MVars

    /*
    
    public $id;
    public $sort;
    public $name;
    public $code;
    public $guid;
    public $title;
    public $tranz;
    public $accept;
    public $active;
    public $delivery_price;
    public $award_order;
    public $award_return;
    public $award_exchange;
    public $bonus;
    public $deposit;
    public $status;
    public $rating;
    public $place_region_ids;
    public $region_form;
    public $user_company_id;
    public $user_id;
    public $auto_id;
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
        'guid',
        'title',
        'tranz',
        'accept',
        'active',
        'delivery_price',
        'award_order',
        'award_return',
        'award_exchange',
        'bonus',
        'deposit',
        'status',
        'rating',
        'place_region_ids',
        'region_form',
        'user_company_id',
        'user_id',
        'auto_id',
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
        'offline' => 'offline',
        'online' => 'online',
        'Busy' => 'Busy',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Курьеры';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_status = [
            'offline' => Az::l('Офлайн'),
            'online' => Az::l('Онлайн'),
            'Busy' => Az::l('Занят'),
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
			'guid',
			'title',
			'tranz',
			'accept',
			'active',
			'delivery_price',
			'award_order',
			'award_return',
			'award_exchange',
			'bonus',
			'deposit',
			'status',
			'rating',
			'place_region_ids',
			'region_form',
			'user_company_id',
			'user_id',
			'auto_id',
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
            $config->addGuid = true;
            $config->hasOne = [
                    'UserCompany' => [
                        'user_company_id' => 'id',
                    ],
                    'User' => [
                        'user_id' => 'id',
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                    'Auto' => [
                        'auto_id' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'PlaceRegion' => [
                        'place_region_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'ShopShipment' => [
                        'shop_courier_id' => 'id',
                    ],
                    'WareAccept' => [
                        'shop_courier_id' => 'id',
                    ],
                    'WareExit' => [
                        'shop_courier_id' => 'id',
                    ],
                    'WareReturn' => [
                        'shop_courier_id' => 'id',
                    ],
                    'PlaceLocation' => [
                        'shop_courier_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Курьеры');

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

            'delivery_price' => function (FormDb $column) {

                $column->title = Az::l('Сумма доставки за 1 км');
                $column->tooltip = Az::l('Сумма доставки заказа за 1км курьером');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'award_order' => function (FormDb $column) {

                $column->title = Az::l('Вознаграждение за выкуп');
                $column->tooltip = Az::l('Вознаграждение за выкупленный заказ курьеру');
                $column->dbType = dbTypeDouble;
                $column->rules = [
                    [
                        validatorDouble,
                    ],
                ];

                return $column;
            },


            'award_return' => function (FormDb $column) {

                $column->title = Az::l('Вознаграждение за возврат');
                $column->tooltip = Az::l('Вознаграждение за осуществление возврата товаров курьеру');
                $column->dbType = dbTypeDouble;
                $column->rules = [
                    [
                        validatorDouble,
                    ],
                ];

                return $column;
            },


            'award_exchange' => function (FormDb $column) {

                $column->title = Az::l('Вознаграждение за обмен');
                $column->tooltip = Az::l('Вознаграждение за осуществление обмен товаров курьеру');
                $column->dbType = dbTypeDouble;
                $column->rules = [
                    [
                        validatorDouble,
                    ],
                ];

                return $column;
            },


            'bonus' => function (FormDb $column) {

                $column->title = Az::l('Бонус');
                $column->tooltip = Az::l('Дополнительный бонус для курьера');
                $column->dbType = dbTypeDouble;
                $column->rules = [
                    [
                        validatorDouble,
                    ],
                ];

                return $column;
            },


            'deposit' => function (FormDb $column) {

                $column->title = Az::l('Сумма депозита');
                $column->tooltip = Az::l('Сумма депозита курьера');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'status' => function (FormDb $column) {

                $column->title = Az::l('Статус');
                $column->tooltip = Az::l('Статус курьера');
                $column->data = [
                    'offline' => Az::l('Офлайн'),
                    'online' => Az::l('Онлайн'),
                    'Busy' => Az::l('Занят'),
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'rating' => function (FormDb $column) {

                $column->title = Az::l('Рейтинг');
                $column->tooltip = Az::l('Рейтинг курьера');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKStarRatingWidget::class;

                return $column;
            },


            'place_region_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Регион обслуживания');
                $column->tooltip = Az::l('Обслуживаемые регионы для доставки заказов курьера');
                $column->dbType = dbTypeJsonb;
                $column->readonly = true;
                $column->readonlyWidget = true;
                $column->auto = true;
                $column->autoValue = function ($model) {

                    $values = $model->region_form;

                    $value = null;
                    if (!empty($values))
                        $value = end($values);

                    return $value;

                };
                $column->widget = ZKSelect2Widget::class;
                $column->multiple = true;

                return $column;
            },


            'region_form' => function (FormDb $column) {

                $column->title = Az::l('Регионы');
                $column->dbType = dbTypeJsonb;
                $column->changeSave = false;
                $column->widget = ZFormWidget::class;

                if (!$this->callableCan())
                    return $column;

                $app = new ALLApp();

                $configs = new Config();
                $configs->changeSave = true;
                $configs->formId = $this->configs->formId;

                $app->parentAttr = 'region_form';
                $app->parentClass = self::class;
                $app->parentId = $this->id;
                $app->configs = $configs;

                //start|DavlatovRavshan|2020.10.11

                $formEx = new Form();
                $formEx->title = Az::l('Основной регион');
                $formEx->fkTable = 'place_region';
                $formEx->changeSave = true;
                $formEx->fkQuery = [
                    'parent_id' => null,
                ];
                $formEx->widget = ZKSelect2Widget::class;
                $formEx->options = [
                    'config' => [
                        'multiple' => true
                    ]
                ];

                $app->columns['region_0'] = $formEx;

                $values = $this->region_form;

                $i = 1;
                $bool = false;
                if (!empty($values)) {
                    foreach ($values as $value) {

                        $parentValue = ZArrayHelper::getValue($values, 'region_0');
                        if (empty($parentValue)) {
                            $bool = true;
                            continue;
                        }

                        $region = null;
                        if (!empty($value))
                            $region = PlaceRegion::findAll([
                                'parent_id' => $value
                            ]);

                        if (!empty($region)) {

                            $form = clone $formEx;
                            $form->title = Az::l('Регион уровня #' . $i);
                            $form->fkQuery = [
                                'parent_id' => $value
                            ];
                            $app->columns['region_' . $i] = $form;

                        }
                        $i++;
                    }
                }

                if ($bool) {
                    $this->region_form = null;
                }

                $object = Az::$app->forms->former->model($app, null, $values);

                //end|DavlatovRavshan|2020.10.11

                $column->options = [
                    'config' => [
                        'formObject' => $object,
                    ],
                ];

                return $column;
            },


            'user_company_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Компания');
                $column->tooltip = Az::l('Компания на которую обслуживает курьер');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'type' => 'logistics',
                ];

                return $column;
            },


            'user_id' => function (FormDb $column) {

                $column->index = true;
                $column->indexUnique = true;
                $column->title = Az::l('Курьер');
                $column->tooltip = Az::l('Имя или логин курьера');
                $column->dbType = dbTypeInteger;
                $column->rules = validatorInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkQuery = [
                    'role' => 'deliver',
                ];

                return $column;
            },


            'auto_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Автомобиль курьера');
                $column->tooltip = Az::l('Марка автомобиля на котором курьер доставляет заказы');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
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
        'code',
        'guid',
        'title',
        'tranz',
        'accept',
        'active',
        'delivery_price',
        'award_order',
        'award_return',
        'award_exchange',
        'bonus',
        'deposit',
        'status',
        'rating',
        'place_region_ids',
        'region_form',
        'user_company_id',
        'user_id',
        'auto_id',
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
                                'user_id',
                            ],
                            [
                                'region_form',
                            ],
                            [
                                'place_region_ids',
                            ],
                            [
                                'delivery_price',
                                'rating',
                                'status',
                            ],
                            [
                                'award_order',
                                'award_return',
                                'award_exchange',
                            ],
                            [
                                'deposit',
                                'user_company_id',
                            ],
                            [
                                'auto_id',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(ShopCourier $model = null)
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
     * Function  getAuto
     * @return bool|\yii\db\ActiveRecord|Auto|null
     */            
    public function getAutoOne()
    {
        return $this->getOne(Auto::class, [
          'id' => 'auto_id',
      ]);    
    }
    
     /**
     *
     * Function  getAuto
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getAuto()
    {
        return $this->hasOne(Auto::class, [
          'id' => 'auto_id',
      ]);    
    }
    
    


    #endregion

    #region Multi


    /**
     *
     * Function  getPlaceRegionsFromPlaceRegionIdsMulti
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsFromPlaceRegionIdsMulti()
    {
        return $this->getMulti(PlaceRegion::class, [
          'id' => 'place_region_ids',
      ]);    
    }


    #endregion
    
    #region Many


    /**
     *
     * Function  getShopShipmentsWithShopCourierIdMany
     * @return  null|\yii\db\ActiveRecord[]|ShopShipment
     */            
    public function getShopShipmentsWithShopCourierIdMany()
    {
       return $this->getMany(ShopShipment::class, [
            'shop_courier_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getShopShipmentsWithShopCourierId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getShopShipmentsWithShopCourierId()
    {
       return $this->hasMany(ShopShipment::class, [
            'shop_courier_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareAcceptsWithShopCourierIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareAccept
     */            
    public function getWareAcceptsWithShopCourierIdMany()
    {
       return $this->getMany(WareAccept::class, [
            'shop_courier_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareAcceptsWithShopCourierId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareAcceptsWithShopCourierId()
    {
       return $this->hasMany(WareAccept::class, [
            'shop_courier_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareExitsWithShopCourierIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareExit
     */            
    public function getWareExitsWithShopCourierIdMany()
    {
       return $this->getMany(WareExit::class, [
            'shop_courier_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareExitsWithShopCourierId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareExitsWithShopCourierId()
    {
       return $this->hasMany(WareExit::class, [
            'shop_courier_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getWareReturnsWithShopCourierIdMany
     * @return  null|\yii\db\ActiveRecord[]|WareReturn
     */            
    public function getWareReturnsWithShopCourierIdMany()
    {
       return $this->getMany(WareReturn::class, [
            'shop_courier_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getWareReturnsWithShopCourierId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getWareReturnsWithShopCourierId()
    {
       return $this->hasMany(WareReturn::class, [
            'shop_courier_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceLocationsWithShopCourierIdMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceLocation
     */            
    public function getPlaceLocationsWithShopCourierIdMany()
    {
       return $this->getMany(PlaceLocation::class, [
            'shop_courier_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceLocationsWithShopCourierId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceLocationsWithShopCourierId()
    {
       return $this->hasMany(PlaceLocation::class, [
            'shop_courier_id' => 'id',
        ]);     
    }


    #endregion


}

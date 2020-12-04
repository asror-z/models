<?php

/**
 *
 *
 * Author:  Asror Zakirov
 * https://www.linkedin.com/in/asror-zakirov
 * https://github.com/asror-z
 *
 */

namespace zetsoft\models\place;


use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\place\PlaceCountry;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZDepdropWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\models\user\User;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\ware\Ware;
use zetsoft\models\shop\ShopCourier;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\pays\PaysSysClick;
use zetsoft\models\pays\PaysSysOson;
use zetsoft\models\pays\PaysSysPayme;
use zetsoft\models\pays\PaysSysPaysys;
use zetsoft\models\pays\PaysSysUzcard;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PlaceRegion
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $place_country_id
 * @property string $type
 * @property int $parent_id
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PlaceRegion extends ZActiveRecord
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
    public $place_country_id;
    public $type;
    public $parent_id;
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
        'place_country_id',
        'type',
        'parent_id',
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
        'region' => 'region',
        'city' => 'city',
        'district' => 'district',
        'area' => 'area',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Регионы';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_type = [
            'region' => Az::l('Область'),
            'city' => Az::l('Город'),
            'district' => Az::l('Район'),
            'area' => Az::l('Массив'),
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
			'place_country_id',
			'type',
			'parent_id',
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

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $config->nameValue = function ($model) {
                /** @var PlaceRegion $model */

                $country = PlaceCountry::findOne($model->place_country_id);

                if ($country === null)
                    return null;

                $parent_name = $country->name;
                if ((int)$model->parent_id > 0) {
                    $parent = PlaceRegion::findOne($model->parent_id);
                    if ($parent !== null)
                        $parent_name = $parent->name;
                }

                return $model->title . ' | ' . $parent_name;

            };

            $config->nameShowForm = false;
            $config->hasOne = [
                    'PlaceCountry' => [
                        'place_country_id' => 'id',
                    ],
                    'PlaceRegion' => [
                        'parent_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'PaysSysClick' => [
                        'place_region_id' => 'id',
                        'parent_id' => 'id',
                    ],
                    'PaysSysOson' => [
                        'place_region_id' => 'id',
                        'parent_id' => 'id',
                    ],
                    'PaysSysPayme' => [
                        'place_region_id' => 'id',
                        'parent_id' => 'id',
                    ],
                    'PaysSysPaysys' => [
                        'place_region_id' => 'id',
                        'parent_id' => 'id',
                    ],
                    'PaysSysUzcard' => [
                        'place_region_id' => 'id',
                        'parent_id' => 'id',
                    ],
                    'User' => [
                        'place_region_id' => 'id',
                    ],
                    'PlaceAdress' => [
                        'place_region_id' => 'id',
                    ],
                    'PlaceRegion' => [
                        'parent_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Регионы');

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

        $return = ZArrayHelper::merge(parent::column(), [



            'place_country_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Страна');
                $column->tooltip = Az::l('Страна');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },

            'type' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Тип');
                $column->tooltip = Az::l('Тип региона (Область,Район,Город)');
                $column->dbType = dbTypeString;
                $column->rules = [
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->data = [
                    'region' => Az::l('Область'),
                    'city' => Az::l('Город'),
                    'district' => Az::l('Район'),
                    'area' => Az::l('Массив'),
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'parent_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Вышестоящий');
                $column->tooltip = Az::l('Связанный вышестоящий регион');
                $column->dbType = dbTypeInteger;
                $column->widget = ZKSelect2Widget::class;
                $column->fkTable = 'place_region';

                return $column;
            },


            /**
             *
             * MarketPlace
             */

        ], $this->configs->replace);


        $isShop = ZArrayHelper::isIn('shop', $this->bootEnv('dbModel'));

        if ($isShop) {
            $return = ZArrayHelper::merge($return, [

                'delivery_price' => function (FormDb $column) {

                    $column->title = Az::l('Фиксированная сумма доставки');
                    $column->tooltip = Az::l('Фиксированная сумма доставки для данного региона');
                    $column->dbType = dbTypeInteger;
                    $column->rules = [
                        [
                            validatorInteger,
                        ],
                    ];

                    return $column;
                },

                'ware_id' => function (FormDb $column) {

                    $column->index = true;
                    $column->title = Az::l('Обслуживаемый склад');
                    $column->tooltip = Az::l('Обслуживаемый склад для данного региона');
                    $column->dbType = dbTypeInteger;
                    $column->widget = ZKSelect2Widget::class;

                    return $column;
                },

            ]);
        }


        return $return;
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
        'place_country_id',
        'type',
        'parent_id',
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
                                'title',
                            ],
                            [
                                'delivery_price',
                            ],
                            [
                                'place_country_id',
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
    public function value(PlaceRegion $model = null)
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
     * Function  getPlaceCountry
     * @return bool|\yii\db\ActiveRecord|PlaceCountry|null
     */            
    public function getPlaceCountryOne()
    {
        return $this->getOne(PlaceCountry::class, [
          'id' => 'place_country_id',
      ]);    
    }
    
     /**
     *
     * Function  getPlaceCountry
     * @return \yii\db\ActiveQuery | ZActiveQuery
     */            
    public function getPlaceCountry()
    {
        return $this->hasOne(PlaceCountry::class, [
          'id' => 'place_country_id',
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
     * Function  getPaysSysClicksWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysClick
     */            
    public function getPaysSysClicksWithPlaceRegionIdMany()
    {
       return $this->getMany(PaysSysClick::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysClicksWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysClicksWithPlaceRegionId()
    {
       return $this->hasMany(PaysSysClick::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysClicksWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysClick
     */            
    public function getPaysSysClicksWithParentIdMany()
    {
       return $this->getMany(PaysSysClick::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysClicksWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysClicksWithParentId()
    {
       return $this->hasMany(PaysSysClick::class, [
            'parent_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysOsonsWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysOson
     */            
    public function getPaysSysOsonsWithPlaceRegionIdMany()
    {
       return $this->getMany(PaysSysOson::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysOsonsWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysOsonsWithPlaceRegionId()
    {
       return $this->hasMany(PaysSysOson::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysOsonsWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysOson
     */            
    public function getPaysSysOsonsWithParentIdMany()
    {
       return $this->getMany(PaysSysOson::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysOsonsWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysOsonsWithParentId()
    {
       return $this->hasMany(PaysSysOson::class, [
            'parent_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaymesWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPayme
     */            
    public function getPaysSysPaymesWithPlaceRegionIdMany()
    {
       return $this->getMany(PaysSysPayme::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaymesWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaymesWithPlaceRegionId()
    {
       return $this->hasMany(PaysSysPayme::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaymesWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPayme
     */            
    public function getPaysSysPaymesWithParentIdMany()
    {
       return $this->getMany(PaysSysPayme::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaymesWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaymesWithParentId()
    {
       return $this->hasMany(PaysSysPayme::class, [
            'parent_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaysysWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPaysys
     */            
    public function getPaysSysPaysysWithPlaceRegionIdMany()
    {
       return $this->getMany(PaysSysPaysys::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaysysWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaysysWithPlaceRegionId()
    {
       return $this->hasMany(PaysSysPaysys::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysPaysysWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysPaysys
     */            
    public function getPaysSysPaysysWithParentIdMany()
    {
       return $this->getMany(PaysSysPaysys::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysPaysysWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysPaysysWithParentId()
    {
       return $this->hasMany(PaysSysPaysys::class, [
            'parent_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysUzcardsWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysUzcard
     */            
    public function getPaysSysUzcardsWithPlaceRegionIdMany()
    {
       return $this->getMany(PaysSysUzcard::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysUzcardsWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysUzcardsWithPlaceRegionId()
    {
       return $this->hasMany(PaysSysUzcard::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPaysSysUzcardsWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PaysSysUzcard
     */            
    public function getPaysSysUzcardsWithParentIdMany()
    {
       return $this->getMany(PaysSysUzcard::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPaysSysUzcardsWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPaysSysUzcardsWithParentId()
    {
       return $this->hasMany(PaysSysUzcard::class, [
            'parent_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getUsersWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|User
     */            
    public function getUsersWithPlaceRegionIdMany()
    {
       return $this->getMany(User::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getUsersWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getUsersWithPlaceRegionId()
    {
       return $this->hasMany(User::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceAdressesWithPlaceRegionIdMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceAdress
     */            
    public function getPlaceAdressesWithPlaceRegionIdMany()
    {
       return $this->getMany(PlaceAdress::class, [
            'place_region_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceAdressesWithPlaceRegionId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceAdressesWithPlaceRegionId()
    {
       return $this->hasMany(PlaceAdress::class, [
            'place_region_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceRegionsWithParentIdMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsWithParentIdMany()
    {
       return $this->getMany(PlaceRegion::class, [
            'parent_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceRegionsWithParentId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceRegionsWithParentId()
    {
       return $this->hasMany(PlaceRegion::class, [
            'parent_id' => 'id',
        ]);     
    }


    #endregion


}

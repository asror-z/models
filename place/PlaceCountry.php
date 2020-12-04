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


use Closure;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\shop\ShopOrder;
use zetsoft\models\ware\WareAccept;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\system\Az;
use zetsoft\system\module\Models;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKDatepickerWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\dbitem\data\Event;
use zetsoft\models\user\User;
use zetsoft\widgets\inputes\ZKSelect2WidgetRav;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\models\place\PlaceAdress;
use zetsoft\models\place\PlaceRegion;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\cpas\CpasOfferItem;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\models\pays\PaysCurrency;
use zetsoft\models\cpas\CpasLand;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    PlaceCountry
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property string $alpha2
 * @property string $alpha3
 * @property string $date
 * @property int $numeric
 * @property string $itu
 * @property int $phone
 * @property string $continent
 * @property array $shop_currency_ids
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class PlaceCountry extends ZActiveRecord
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
    public $alpha2;
    public $alpha3;
    public $date;
    public $numeric;
    public $itu;
    public $phone;
    public $continent;
    public $shop_currency_ids;
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
        'alpha2',
        'alpha3',
        'date',
        'numeric',
        'itu',
        'phone',
        'continent',
        'shop_currency_ids',
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

    /* @var array $_continent*/
    public $_continent;  
    public const continent = [
        'africa' => 'africa',
        'asia' => 'asia',
        'europe' => 'europe',
        'north_america' => 'north_america',
        'australia_oceania' => 'australia_oceania',
        'south_america' => 'south_america',
        'antarctica' => 'antarctica',
    ];

    #endregion

    ##region Init

    public static ?string $dbase = 'db';
    public static ?string $title = Azl . 'Страны';
    public static ?string $icon = '';
    public static ?bool $menu = true;

    public function init()
    {
        parent::init();

        $this->_continent = [
            'africa' => Az::l('Африка'),
            'asia' => Az::l('Азия'),
            'europe' => Az::l('Европа'),
            'north_america' => Az::l('Северная Америка'),
            'australia_oceania' => Az::l('Австралия и Океания'),
            'south_america' => Az::l('Южная Америка'),
            'antarctica' => Az::l('Антарктида'),
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
			'alpha2',
			'alpha3',
			'date',
			'numeric',
			'itu',
			'phone',
			'continent',
			'shop_currency_ids',
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

            $config->nameLang = true;
            $config->hasOne = [
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMulti = [
                    'ShopCurrency' => [
                        'shop_currency_ids' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'PlaceAdress' => [
                        'place_country_id' => 'id',
                    ],
                    'PlaceRegion' => [
                        'place_country_id' => 'id',
                    ],
                    'EyufCompatriot' => [
                        'citizenship' => 'id',
                        'place_country_id' => 'id',
                    ],
                    'EyufNeedCompatriot' => [
                        'place_country_id' => 'id',
                    ],
                    'EyufScholar' => [
                        'place_country_id' => 'id',
                    ],
                    'EyufTable' => [
                        'citizenship' => 'id',
                        'place_country_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Страны');

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

            'alpha2' => function (FormDb $column) {

                $column->title = Az::l('Код Alpha-2');
                $column->tooltip = Az::l('Код Alpha-2');

                return $column;
            },


            'alpha3' => function (FormDb $column) {

                $column->title = Az::l('Код Alpha-3');
                $column->tooltip = Az::l('Код Alpha-3');
                return $column;
            },


            'date' => function (FormDb $column) {

                $column->title = Az::l('Дата');
                $column->tooltip = Az::l('Дата создания');
                $column->dbType = dbTypeDate;
                $column->widget = ZKDatepickerWidget::class;
                return $column;
            },


            'numeric' => function (FormDb $column) {

                $column->title = Az::l('Номерной код');
                $column->tooltip = Az::l('Номерной код');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];

                return $column;
            },


            'itu' => function (FormDb $column) {

                $column->title = Az::l('Код ITU');
                $column->tooltip = Az::l('Код ITU');

                return $column;
            },


            'phone' => function (FormDb $column) {

                $column->title = Az::l('Код телефона');
                $column->tooltip = Az::l('Код телефона');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];

                return $column;
            },


            'continent' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Континент');
                $column->tooltip = Az::l('Континент');
                $column->data = [
                    'africa' => Az::l('Африка'),
                    'asia' => Az::l('Азия'),
                    'europe' => Az::l('Европа'),
                    'north_america' => Az::l('Северная Америка'),
                    'australia_oceania' => Az::l('Австралия и Океания'),
                    'south_america' => Az::l('Южная Америка'),
                    'antarctica' => Az::l('Антарктида'),
                ];
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'shop_currency_ids' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Принимаемые валюты');
                $column->tooltip = Az::l('Возможные принимаемые валюты');
                $column->dbType = dbTypeJsonb;
                $column->addPlus = true;
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
        'alpha2',
        'alpha3',
        'date',
        'numeric',
        'itu',
        'phone',
        'continent',
        'shop_currency_ids',
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
                                'alpha2',
                                'alpha3',
                            ],
                            [
                                'numeric',
                                'itu',
                                'phone',
                            ],
                            [
                                'continent',
                                'shop_currency_ids',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region Value
    public function value(PlaceCountry $model = null)
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
        $event->beforeDelete = function (PlaceCountry $model) {
        return null;
        };

        $event->afterDelete = function (PlaceCountry $model) {
        return null;
        };

        $event->beforeSave = function (PlaceCountry $model) {
        return null;
        };

        $event->afterSave = function (PlaceCountry $model) {
        return null;
        };

        $event->beforeValidate = function (PlaceCountry $model) {
        return null;
        };

        $event->afterValidate = function (PlaceCountry $model) {
        return null;
        };

        $event->afterRefresh = function (PlaceCountry $model) {
        return null;
        };

        $event->afterFind = function (PlaceCountry $model) {
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


    /**
     *
     * Function  getPlaceAdressesWithPlaceCountryIdMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceAdress
     */            
    public function getPlaceAdressesWithPlaceCountryIdMany()
    {
       return $this->getMany(PlaceAdress::class, [
            'place_country_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceAdressesWithPlaceCountryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceAdressesWithPlaceCountryId()
    {
       return $this->hasMany(PlaceAdress::class, [
            'place_country_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getPlaceRegionsWithPlaceCountryIdMany
     * @return  null|\yii\db\ActiveRecord[]|PlaceRegion
     */            
    public function getPlaceRegionsWithPlaceCountryIdMany()
    {
       return $this->getMany(PlaceRegion::class, [
            'place_country_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getPlaceRegionsWithPlaceCountryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getPlaceRegionsWithPlaceCountryId()
    {
       return $this->hasMany(PlaceRegion::class, [
            'place_country_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufCompatriotsWithCitizenshipMany
     * @return  null|\yii\db\ActiveRecord[]|EyufCompatriot
     */            
    public function getEyufCompatriotsWithCitizenshipMany()
    {
       return $this->getMany(EyufCompatriot::class, [
            'citizenship' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufCompatriotsWithCitizenship
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufCompatriotsWithCitizenship()
    {
       return $this->hasMany(EyufCompatriot::class, [
            'citizenship' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufCompatriotsWithPlaceCountryIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufCompatriot
     */            
    public function getEyufCompatriotsWithPlaceCountryIdMany()
    {
       return $this->getMany(EyufCompatriot::class, [
            'place_country_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufCompatriotsWithPlaceCountryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufCompatriotsWithPlaceCountryId()
    {
       return $this->hasMany(EyufCompatriot::class, [
            'place_country_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufNeedCompatriotsWithPlaceCountryIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufNeedCompatriot
     */            
    public function getEyufNeedCompatriotsWithPlaceCountryIdMany()
    {
       return $this->getMany(EyufNeedCompatriot::class, [
            'place_country_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufNeedCompatriotsWithPlaceCountryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufNeedCompatriotsWithPlaceCountryId()
    {
       return $this->hasMany(EyufNeedCompatriot::class, [
            'place_country_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufScholarsWithPlaceCountryIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufScholar
     */            
    public function getEyufScholarsWithPlaceCountryIdMany()
    {
       return $this->getMany(EyufScholar::class, [
            'place_country_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufScholarsWithPlaceCountryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufScholarsWithPlaceCountryId()
    {
       return $this->hasMany(EyufScholar::class, [
            'place_country_id' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTablesWithCitizenshipMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTable
     */            
    public function getEyufTablesWithCitizenshipMany()
    {
       return $this->getMany(EyufTable::class, [
            'citizenship' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTablesWithCitizenship
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTablesWithCitizenship()
    {
       return $this->hasMany(EyufTable::class, [
            'citizenship' => 'id',
        ]);     
    }

    /**
     *
     * Function  getEyufTablesWithPlaceCountryIdMany
     * @return  null|\yii\db\ActiveRecord[]|EyufTable
     */            
    public function getEyufTablesWithPlaceCountryIdMany()
    {
       return $this->getMany(EyufTable::class, [
            'place_country_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getEyufTablesWithPlaceCountryId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getEyufTablesWithPlaceCountryId()
    {
       return $this->hasMany(EyufTable::class, [
            'place_country_id' => 'id',
        ]);     
    }


    #endregion


}

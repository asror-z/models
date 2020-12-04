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


use zetsoft\dbdata\core\LangData;
use zetsoft\dbdata\shop\CurrencyData;
use zetsoft\dbitem\data\ConfigDB;
use zetsoft\dbitem\data\Event;
use zetsoft\dbitem\data\FormDb;
use zetsoft\models\place\PlaceCountry;
use zetsoft\models\user\User;
use zetsoft\system\actives\ZActiveQuery;
use zetsoft\system\actives\ZActiveRecord;
use zetsoft\system\Az;
use zetsoft\system\helpers\ZArrayHelper;
use zetsoft\widgets\inputes\ZInputWidget;
use zetsoft\widgets\inputes\ZKSelect2Widget;
use zetsoft\widgets\inputes\ZSelect2Widget;
use zetsoft\widgets\values\ZSuffixWidget;
use zetsoft\models\cpas\CpasOffer;
use zetsoft\models\cpas\CpasLand;
use zetsoft\dbitem\data\Config;
use zetsoft\system\actives\ZModel;
use zetsoft\widgets\inputes\ZHInputWidget;
use zetsoft\widgets\inputes\ZKSwitchInputWidget;
use zetsoft\widgets\incores\ZMCheckboxWidget;



/**
 * Class    CpasOfferItem
 * @package zetsoft\models\App
 * 
 * @property int $id
 * @property int $sort
 * @property string $name
 * @property string $title
 * @property boolean $tranz
 * @property boolean $accept
 * @property boolean $active
 * @property int $cpas_offer_id
 * @property int $place_country_id
 * @property int $pay
 * @property string $pay_currency
 * @property int $cost
 * @property string $cost_currency
 * @property string $aproove
 * @property string $deleted_at
 * @property int $deleted_by
 * @property string $deleted_text
 * @property string $created_at
 * @property string $modified_at
 * @property int $created_by
 * @property int $modified_by
 */
class CpasOfferItem extends ZActiveRecord
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
    public $cpas_offer_id;
    public $place_country_id;
    public $pay;
    public $pay_currency;
    public $cost;
    public $cost_currency;
    public $aproove;
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
        'cpas_offer_id',
        'place_country_id',
        'pay',
        'pay_currency',
        'cost',
        'cost_currency',
        'aproove',
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
    public static ?string $title = Azl . 'Элемент патока';
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
			'cpas_offer_id',
			'place_country_id',
			'pay',
			'pay_currency',
			'cost',
			'cost_currency',
			'aproove',
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
                    'CpasOffer' => [
                        'cpas_offer_id' => 'id',
                    ],
                    'PlaceCountry' => [
                        'place_country_id' => 'id',
                    ],
                    'User' => [
                        'deleted_by' => 'id',
                        'created_by' => 'id',
                        'modified_by' => 'id',
                    ],
                ];
            $config->hasMany = [
                    'CpasLand' => [
                        'cpas_offer_item_id' => 'id',
                    ],
                ];
            $config->title = Az::l('Элемент патока');

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

            'cpas_offer_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Оффер');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;

                return $column;
            },


            'place_country_id' => function (FormDb $column) {

                $column->index = true;
                $column->title = Az::l('Страна');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],

                    [
                        'zetsoft\\system\\validate\\ZRequiredValidator',
                    ],
                ];
                $column->widget = ZKSelect2Widget::class;
                $column->ajax = false;

                return $column;
            },


            'pay' => function (FormDb $column) {

                $column->title = Az::l('Сумма выплаты');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];
                $column->valueWidget = ZSuffixWidget::class;
                $column->valueOptions = [
                    'config' => [
                        'suffix' => function ($model, $attribute, $value) {
                            if ($value !== null)
                                return ' ' . $model->pay_currency;
                            return null;
                        },

                    ],
                ];


                return $column;
            },


            'pay_currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта выплаты');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->data = CurrencyData::class;
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'cost' => function (FormDb $column) {

                $column->title = Az::l('Цена на лэндинге');
                $column->dbType = dbTypeInteger;
                $column->rules = [
                    [
                        validatorInteger,
                    ],
                ];


                return $column;
            },


            'cost_currency' => function (FormDb $column) {

                $column->title = Az::l('Валюта на лэндинге');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->data = CurrencyData::class;
                $column->widget = ZKSelect2Widget::class;

                //start|AlisherXayrillayev|2020-10-15
                $column->ajax = false;
                //end|AlisherXayrillayev|2020-10-15

                return $column;
            },


            'aproove' => function (FormDb $column) {

                $column->title = Az::l('Средний апрув');
                $column->rules = [
                    [
                        validatorString,
                    ],
                ];
                $column->valueWidget = ZSuffixWidget::class;
                $column->valueOptions = [
                    'config' => [
                        'suffix' => function ($model, $attribute, $value) {
                            if ($value === null)
                                return null;
                            if (substr($value, -1) === '%')
                                return null;
                            return '%';
                        },

                    ],
                ];


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
        'cpas_offer_id',
        'place_country_id',
        'pay',
        'pay_currency',
        'cost',
        'cost_currency',
        'aproove',
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
                                'cpas_offer_id',
                                'place_country_id',
                                'pay',
                                'pay_currency',
                                'cost',
                                'cost_currency',
                                'aproove',
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
    public function value(CpasOfferItem $model = null)
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

        $event->beforeSave = function (CpasOfferItem $model) {
            Az::$app->cpas->cpa->createOfferItemFolder($model);
            return true;
        };

        $event->beforeDelete = function (CpasOfferItem $model) {
            Az::$app->cpas->cpa->deleteItemRelations($model);
        };

        /*
        $event->beforeDelete = function (ShopBrand $model) {
        return null;
        };

        $event->afterDelete = function (ShopBrand $model) {
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
     * Function  getCpasLandsWithCpasOfferItemIdMany
     * @return  null|\yii\db\ActiveRecord[]|CpasLand
     */            
    public function getCpasLandsWithCpasOfferItemIdMany()
    {
       return $this->getMany(CpasLand::class, [
            'cpas_offer_item_id' => 'id',
        ]);     
    }
    
    /**
     *
     * Function  getCpasLandsWithCpasOfferItemId
     * @return  null|\yii\db\ActiveQuery
     */            
    public function getCpasLandsWithCpasOfferItemId()
    {
       return $this->hasMany(CpasLand::class, [
            'cpas_offer_item_id' => 'id',
        ]);     
    }


    #endregion


}
